<?php

include '../../functions/abstract/query.php';

if(empty($_POST['thread_id']) && !empty($_POST['recipient_id'])) //Compose new thread!
{
	$sender_id = (int) $_POST['sender_id'];
	$recipient_id =  array_map('intval', explode(',',$_POST['recipient_id']));
	$message_string = $_POST['message_string'];

	$thread_size = sizeof($recipient_id)+1;
	$thread_name = "test";

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
			SET thread_name = :thread_name;
			"; 
				
			$params = array(
			'thread_name' => $thread_name
			);

			$result = query($action, $query, $params);

			$new_thread_id = $result['insertId'];

			if ($result['outcome'] === 0)
			{
				$result['response'] = "Thread cannot be inserted!";
			}
			elseif ($result['outcome'] === 1)
			{
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

				if ($result['outcome'] === 0)
				{
					$result['response'] = "Sender cannot cannot be inserted!";
				}
				elseif ($result['outcome'] === 1)
				{
					foreach ($recipient_id as $element) //On successfully inserted sender, loops through the recipients and insert them into user_thread along with the respective thread.
					{
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
						$result['response'] = "Recipient/s cannot cannot be inserted!";
					}
					elseif ($result['outcome'] === 1) //On success of inserting a user and the respective thread into user_thread a new message is inserted into the newly created thread. 
					{
						$action = 1;

						$query = "
						INSERT INTO message
						SET sender_id = :sender_id,
						thread_id = :new_thread_id,
						message_string = :message_string,
						created = now()
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
							$result['response'] = "Insert new message for new thread failed!";

						}
						elseif($result['outcome'] === 1) //On successful new message insert, the senders message and detials are being queried.
						{
							$action = 2;

							$query = "
							SELECT first_name, middle_name, last_name, photo_content, message_id, sender_id, message_string, created
							FROM user, photo, message
							WHERE user_id = :sender_id1 AND user.profile_picture_id = photo.photo_id AND thread_id = :new_thread_id and user_id = :sender_id2
							";

							$params =
							array(
							'sender_id1' => $sender_id,
							'sender_id2' => $sender_id,
							'new_thread_id' => $new_thread_id
							);

							$result = query($action, $query, $params);

							if($result['outcome'] === 0)
							{
								$result['response'] = "Failed to retrieve sender's info!";
							}
							elseif($result['outcome'] === 1) //On successfully retrieved sender's details. The recipient/s details are retrieved.
							{
								$result['response'][0]->photo_content = base64_encode($result['response'][0]->photo_content);
								if($result['response'][0]->middle_name === null)
								{
									$result['response'][0]->middle_name = "";
								}

								$sender_user = $result['response'][0];
								$sender_name = $result['response'][0]->first_name . ' ' . $result['response'][0]->last_name;
								$sender_name_multi = $result['response'][0]->first_name;

								if(sizeof($recipient_id)===1) // If it is a two way conversation.
								{
									$action = 2;

									$query = "
									SELECT first_name, middle_name, last_name
									FROM user
									WHERE user_id = :recipient
									";

									$params = array(
									'recipient' => $recipient_id[0]
									);

									$result = query($action, $query, $params);
									if($result['outcome'] === 0)
									{
										$result['response'] = "Failed to read recipient personal details!";
									}
									elseif($result['outcome'] === 1) //On success of reading the recipient's related information, thread name is being is being changed to the recipient's first and last name.
									{
										if($result['response'][0]->middle_name === null)
										{
											$result['response'][0]->middle_name = "";
										}

										$recipient_user = $result['response'][0];

										$names = $sender_name . ', ' . $result['response'][0]->first_name . ' ' . $result['response'][0]->last_name;

										$action = 3;
										$query = "
										UPDATE thread
										SET thread_name = :thread_name
										WHERE thread_id = :thread_id
										"; 

										$params = array(
										'thread_name'=> $names,
										'thread_id' => $new_thread_id
							 			);		

										$result = query($action, $query, $params);

										if($result['outcome'] === 0)
										{
											$result['response'] = "Failed to upadate thread name!";
										}
										elseif ($result['outcome'] === 1) 
										{
											$action = 2;

											$query = "
											SELECT thread_name
											FROM thread
											WHERE thread_id = :thread_id
											";

											$params = array(
												'thread_id' => $new_thread_id
											);

											$result = query($action, $query, $params);
											if($result['outcome'] === 0)
											{
												$result['response'] = "Failed to read thread name!";
											}
											elseif($result['outcome'] === 1)
											{
												$thread_name = $result['response'][0];
											}
										}
									
									}
								$users_info = array($sender_user, $thread_name);
								echo json_encode($users_info);
								}
								elseif (sizeof($recipient_id)>1) // If it's a multi user (>2) conversation.
								{
									$names = "";
									$x = 0;
									$recipient_multiuser = array();
									foreach ($recipient_id as $element)
									{
										$action = 2;
								
										$query = "
										SELECT first_name
										FROM user
										WHERE user_id = :recipients
										"; 
									
										$params = array(
										'recipients'=> $element
							 			);

										$result = query($action, $query, $params);
										$recipient_multiuser = array_merge((array)$recipient_multiuser, (array)$result['response']);
										$names = $names . $result['response'][0]->first_name .', ';
										$x++;
									}
									if($result['outcome'] === 0)
									{
										$result['response'] = "Failed to read participants related details!";
									}
									elseif($result['outcome'] === 1) //On success of reading the recipients' related information, thread name is being is being changed to the recipients' firs name.
									{
										$names = substr($names, 0, -2);
										$names_final = $sender_name_multi .', '. $names;
										$action = 3;
										
										$query = "
												UPDATE thread
												SET thread_name = :thread_name
												WHERE thread_id = :thread_id
												"; 

										$params = array(
												'thread_name'=> $names_final,
												'thread_id' => $new_thread_id
									 			);		

										$result = query($action, $query, $params);

										if($result['outcome'] === 0)
										{
											$result['response'] = "Failed to upadate thread name!";
										}
										elseif ($result['outcome'] === 1) 
										{
											$action = 2;

											$query = "
											SELECT thread_name
											FROM thread
											WHERE thread_id = :thread_id
											";

											$params = array(
												'thread_id' => $new_thread_id
											);

											$result = query($action, $query, $params);
											if($result['outcome'] === 0)
											{
												$result['response'] = "Failed to read thread name!";
											}
											elseif($result['outcome'] === 1)
											{
												$thread_name_multi = $result['response'][0];
											}
										}
									}
									$users_info2 = array($sender_user, $thread_name_multi);
									echo json_encode($users_info2);
								}
							}
						}
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
			message_string = :message_string,
			created = now()
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

				foreach ($recipient_id as $element) { //Looping through all the recipients in the given thread and creating the necessary params.

					$tempuser = $tempuser.':user_id_' . $x . ',';
					$user_param_1 = "user_id_".$x;
					$temp = array($user_param_1 => $element);
					$params = array_merge((array)$params, (array)$temp);
					$x++;
				}

				$tempuser = substr($tempuser, 0,-1);

				$action = 2;

					$query = "
						SELECT T1.created, T1.message_string, user.first_name, user.middle_name, user.last_name, photo.photo_content
						FROM
						(
						SELECT thread_id,sender_id,created, message_string
						FROM message
						WHERE sender_id IN ($tempuser) AND thread_id = :thread_id
						ORDER BY created DESC
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
}
elseif (!empty($_POST['thread_id']) && empty($_POST['recipient_id'])) //Reply to an existing thread!
{
	$sender_id = $_POST['sender_id'];
	$message_string = $_POST['message_string'];
	$thread_id = $_POST['thread_id'];

	// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
	$action = 1; //Reading data from the database.

	$query = "
	INSERT INTO message
	SET
	sender_id = :sender_id,
	thread_id = :thread_id,
	message_string = :message_string,
	created = now()
	";

	$params = array(
		'sender_id' => $sender_id,
		'thread_id' => $thread_id,
		'message_string' => $message_string
		);

	$result = query($action, $query, $params);

	if ($result['outcome'] === 0)
	{
		if ($result['response'] === 201)
		{
			$result['response'] = "Query could not be executed!";
		}
		elseif ($result['response'] === 202)
		{
			$result['response'] = "Thread cannot be inserted into messages!";
		}
		elseif ($result['response'] === 203)
		{
			$result['response'] = "Server error!";
		}
		echo json_encode($result);
	}
	elseif ($result['outcome'] === 1) //On success, a for loop encodes all the pictures in the returned responce.
	{

		// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
		$action = 2; //Reading data from the database.

		$query = "
		SELECT user.first_name, user.last_name, photo.photo_content, T1.thread_name, T1.message_string, T1.created, T1.thread_id,T1.sender_id, T1.message_id
		FROM
		(
		SELECT t.thread_name, m.message_string, m.created, m.thread_id, m.sender_id, m.message_id
		FROM message m
		INNER JOIN thread t 
		ON m.thread_id = t.thread_id
		WHERE t.thread_id = :thread_id
		) AS T1
		JOIN user
		ON user.user_id = T1.sender_id
		JOIN photo
		ON photo.photo_id = user.profile_picture_id
		";

		$params = array(
			'thread_id' => $thread_id
			);

		$result = query($action, $query, $params);

		if ($result['outcome'] === 0)
		{
			if ($result['response'] === 201)
			{
				$result['response'] = "Query could not be executed!";
			}
			elseif ($result['response'] === 202)
			{
				$result['response'] = "There is not thread associated with this thread ID!";
			}
			elseif ($result['response'] === 203)
			{
				$result['response'] = "Server error!";
			}
			echo json_encode($result);
		}
		elseif ($result['outcome'] === 1) //On success, a for loop encodes all the pictures in the returned responce.
		{
			$size = sizeof($result['response']);
			for ($i = 0; $i < $size; $i++)
			{
				$result['response'][$i]->photo_content = base64_encode($result['response'][$i]->photo_content);
			}
		}
		echo json_encode($result['response']);
	}
}
?>