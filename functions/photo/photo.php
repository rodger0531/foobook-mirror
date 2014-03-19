<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>
		<meta name="description" content="Foobook is a social network website." />
		<meta name="keywords" content="Social Network, and so on">
		<title>Foobook - Photos</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js "></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="../abstract/ajax.js"></script>
		<script type="text/javascript" src="uploadPhoto.js"></script>
		<?php 
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
		<div>
			<form id="photoUploadForm">
				<h2>Upload Photo:</h2>
				Choose photo:
				<input type="file" name="photo_content"/><br><br>
				<input type="submit" name="submit" value="Upload"/>
			</form>
		</div>
	</body>
</html>