<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http;//www.w3.org/TR/xhtml4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-eqiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<form action="index.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="image">
		<input type="submit" name="submit" value="Upload">
	</form>
	<?php
	if(isset($_POST['submit']))
	{
		mysql_connect("localhost", "root", "");
		mysql_select_db("foobook");

		$imageName = mysql_real_escape_string($_FILES["image"]["name"]);
		$imageData = mysql_real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
		$imageType = mysql_real_escape_string($_FILES["image"]["type"]);

		if(substr($imageType,0,5) == "image")
		{
			mysql_query("INSERT INTO `photo` VALUES('', '1','$imageName','0','$imageData')");
			echo "Image successfully uploaded!!!";
		}
		else
		{
			echo "Only images are allowed!";
		}
	}
	?>

	<img src="showimage.php?photo_id=16">

</body>
</html>