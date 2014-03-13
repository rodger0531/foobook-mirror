<?php

include 'query.php';

// $sender_id = $_POST['sender_id'];
// $recipient_id = $_POST['recipient_id'];
// $message_string = $_POST['message_string'];
// $thread_name = $_POST['thread_name'];

$sender_id = 1; // test
$message_string = "Rodger eating Banana!"; // test
$thread_name = "Testing!"; // test

$recipient_id = array(2,4,5,6,7); // test //The real situation will be that we will be reading an array from the $_POST. 

$thread_size = sizeof($recipient_id)+1;

$action = 2; //Validating whether there is an existing thread for the given set of users.

	$query = "SELECT DISTINCT thread_id FROM user_thread WHERE user_id = :user_id_1 ";
$x = 2;
foreach ($recipient_id as $element) {
	$query .= "OR user_id = :user_id_".$x. " ";
	$x++;
}

$query .="AND thread_id NOT IN(SELECT DISTINCT thread_id FROM user_thread WHERE user_id <> :user_id_1_1 ";

$x = 2;
foreach ($recipient_id as $element) {
	$query .= "AND user_id <> :user_id_1_".$x. " "; 
	$x++; 
}

$query .= ")GROUP BY thread_id HAVING COUNT(user_id) = :thread_size;";

$params = array(
	'user_id_1' => $sender_id,
	'user_id_1_1' => $sender_id
	);

$x = 2;

foreach ($recipient_id as $element) {

	$user_param_1 = "user_id_".$x;
	$user_param_2 = "user_id_1_".$x;	

	$temp = array($user_param_1 => $element, $user_param_2 => $element);

	$params = array_merge((array)$params, (array)$temp);

	$x++;
}
	$temp = array('thread_size' => $thread_size);
	$params = array_merge((array)$params, (array)$temp);

	
	$result = query($action, $query, $params);

if ($result['outcome'] ===0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 202) //If the validation returns that there are not existing rows matching the requirements a new thread is created
	{

		$action = 1; //Insert a new thread.
		
		$query = "
		INSERT INTO thread
		SET name = :thread_name;
		"; 
			
		$params = array(
		'thread_name' => $thread_name
			);

		$result = query($action, $query, $params);

		$new_thread_id = $result['insertId'];

		$action = 1; //Insert the sender to user_thread along the respective thread.
		
		$query = "
			INSERT INTO user_thread
			SET user_id = :sender_id,
			thread_id = :new_thread_id;
			"; 
		
		$params = array(
			'sender_id' => $sender_id,
			'new_thread_id' => $new_thread_id
 			);

		$result = query($action, $query, $params);

		foreach ($recipient_id as $element) { //On successfully inserted sender, loops through the recipients and insert them into user_thread along with the respective thread.

			$action = 1;
			
			$query = "
				INSERT INTO user_thread 
				SET user_id = :user_id,
				thread_id = :new_thread_id;
				"; 
			
			$params = array(
				'user_id'=> $element,
				'new_thread_id' => $new_thread_id
	 			);

			$result = query($action, $query, $params);
		}

		if ($result['outcome'] === 0) //If the foreabove query fails.
		{
			if ($result['response'] === 201)
			{
				$result['response'] = "Query could not be executed!";
			}
			elseif ($result['response'] === 202) 
			{
				$result['response'] = "Insert failed!";
			}
			elseif ($result['response'] === 203)
			{
				$result['response'] = "Server error!";
			}
			echo json_encode($result);
		}
		elseif ($result['outcome'] === 1) //On success of inserting a user and the respective thread into user_thread a new message is inserted into the newly created thread. 
		{

			$action = 1;

			$query = "
			INSERT INTO message
			SET sender_id = :sender_id,
				thread_id = :new_thread_id,
				message_string = :message_string
			";

			$params = 
			array(
				'sender_id' => $sender_id,
				'new_thread_id' => $new_thread_id,
				'message_string' => $message_string
			);

			$result = query($action, $query, $params);

			if($result['outcome'] === 0) //If the foreabove query fails.
			{
				$result['response'] = "New message for new thread failed!";

			}
			elseif($result['outcome'] === 1) //On successful new message insert, the senders message and detials are being queried.
			{

				$action = 2;

				$query = "
				SELECT first_name, middle_name, last_name, message_id, sender_id, message_string, timestamp
				FROM user, message
				WHERE user_id = :sender_id1 AND thread_id = :new_thread_id and user_id = :sender_id2
				";

				$params =
				array(
					'sender_id1' => $sender_id,
					'sender_id2' => $sender_id,
					'new_thread_id' => $new_thread_id 

				$result = query($action, $query, $params);

				if($result['outcome'] === 0)
				{
					$result['response'] = "Failed to read sender's info!";
				}
				elseif($result['outcome'] === 1)
				{

					$result['response'][0]->photo_content = base64_encode($result['response'][0]->photo_content);
					if($result['response'][0]->middle_name === null)
					{
						$result['response'][0]->middle_name = "";
					}
					$sender_user = $result['response'][0];

					if(sizeof($recipient_id)===1){ // If it is a two way conversation.

						$action = 2;

						$query = "
						SELECT first_name, middle_name, last_name
						FROM user
						WHERE user_id = :sender_id
						";

						$params = array(
							'sender_id' => $sender_id
						);

						$result = query($action, $query, $params);

						if($result['outcome'] === 0)
						{
							$result['response'] = "Failed to read sender's personal details!";
						}
						elseif($result['outcome'] === 1) //On success of reading the recipient's related information, thread name is being is being changed to the recipient's first and last name.
						{
							if($result['response'][0]->middle_name === null)
							{
								$result['response'][0]->middle_name = "";
							}
							$recipient_user = $result['response'][0];

							$names = $result['response'][0]->first_name . ' ' . $result['response'][0]->last_name;

							$action = 3;
							$query = "
									UPDATE thread
									SET name = :name
									WHERE thread_id = :thread_id
									"; 

							$params = array(
									'name'=> $names,
									'thread_id' => $new_thread_id
						 			);		

							$result = query($action, $query, $params);
						}
					}

				$users_info = array($sender_user, $recipient_user);

				}
				elseif (sizeof($recipient_id)>1) { // If it's a multi user (>2) conversation.
					$names = "";
					foreach ($recipient_id as $element) {
						$action = 2;
						
						$query = "
							SELECT first_name
							FROM user
							WHERE user_id = :user_id
							"; 
						
						$params = array(
							'user_id'=> $element
				 			);

						$result = query($action, $query, $params);
					
						if($result['outcome'] === 0)
						{
							$result['response'] = "Failed to read participants related details!";
						}
						elseif($result['outcome'] === 1) //On success of reading the recipients' related information, thread name is being is being changed to the recipients' firs name.
						{
							$names = $names . $result['response'][0]->first_name .',';
						}	
						
					}
						$names = substr($names, 0, -1);
						$action = 3;
						$query = "
								UPDATE thread
								SET name = :name
								WHERE thread_id = :thread_id
								"; 

						$params = array(
								'name'=> $names,
								'thread_id' => $new_thread_id
					 			);		

						$result = query($action, $query, $params);
				}
						
			}		
				
		}
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
}
elseif ($result['outcome'] === 1) //If the validation results in a positive outcome, i.e. there is an existing thread for the the given participants the message is inserted into the respective thread.
{
	
	$thread_id = $result['response'][0]->thread_id;

	$action = 1;

	$query = "
	INSERT INTO message
	SET sender_id = :sender_id,
		thread_id = :thread_id,
		message_string = :message_string
	";

	$params = 
	array (
		'sender_id' => $sender_id,
		'thread_id' => $thread_id,
		'message_string' => $message_string
	);

	$result = query($action, $query, $params);

	if ($result['outcome'] === 0) //If the foreabove metioned query fails. 
	{
		if ($result['response'] === 201)
		{
			$result['response'] = "Query could not be executed!";
		}
		elseif ($result['response'] === 202) 
		{
			$result['response'] = "New message failed!";
		}
		elseif ($result['response'] === 203)
		{
			$result['response'] = "Server error!";
		}
		echo json_encode($result);
	}
	elseif ($result['outcome'] === 1) //If the sender's details were successfully retrieved it gets the recipients related details. 
	{

			$tempuser = "";
			$x=1;
			$recipient_id = array_merge((array)$sender_id,$recipient_id);

			$params = array(
				'thread_id' => (int)$thread_id
			);

			foreach ($recipient_id as $element) { //Looping through all the recipients in the given thread and getting their messages and perosnal details.

				$tempuser = $tempuser.':user_id_' . $x . ',';
				$user_param_1 = "user_id_".$x;
				$temp = array($user_param_1 => $element);
				$params = array_merge((array)$params, (array)$temp);
				$x++;
			}

			$tempuser = substr($tempuser, 0,-1);

			$action = 2;

				$query = "
					SELECT T1.timestamp, T1.message_string, user.first_name, user.middle_name, user.last_name, photo.photo_content
					FROM
					(
					SELECT thread_id,sender_id,timestamp, message_string
					FROM message
					WHERE sender_id IN ($tempuser) AND thread_id = :thread_id
					ORDER BY timestamp DESC
					) AS T1
					JOIN user
					ON T1.sender_id = user.user_id
					JOIN photo
					ON user.profile_picture_id = photo.photo_id
				";


				$result = query($action, $query, $params);

				if($result['outcome'] === 0) //If the foreabove metioned query fails.
				{
					$result['response'] = "Failed to fetch the recipient, their info and messages!";

				}
				elseif($result['outcome'] === 1){ //On positive outcome, loop through the results decoding the pictures and hiding the middle name if empty.
					$size = (int)sizeof($result['response']);
					for ($i = 0; $i < $size; $i++){
						$result['response'][$i]->photo_content = base64_encode($result['response'][$i]->photo_content);
						if($result['response'][$i]->middle_name === null)
						{
							$result['response'][$i]->middle_name = "";
						}					
						
					}
				}

	}
	echo json_encode($result['response']);
}

?>