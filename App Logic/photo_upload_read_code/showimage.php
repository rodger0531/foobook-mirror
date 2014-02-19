<?php

	mysql_connect("localhost", "root", "");
	mysql_select_db("foobook");

	if(isset($_GET['photo_id'])){

	$photo_id = mysql_real_escape_string($_GET['photo_id']);
	$query = mysql_query("SELECT * FROM `photo` WHERE `photo_id`='$photo_id'");
	while($row = mysql_fetch_assoc($query))
	{
		$imageData = $row["photo"];
	}
		header("content-type: image/jpeg");
		echo $imageData;
	}
	else
	{
		echo "Error!";
	}
?>