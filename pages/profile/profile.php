<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
        <?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>
        <meta name="description" content="Foobook is a social networking website." />
        <meta name="keywords" content="Foobook, Social Network">
        <title>Foobook</title>
        <link rel="stylesheet" type="text/css" href="profile.css">
        <link rel="stylesheet" type="text/css" href="../../functions/post/post.css">
        <link rel="stylesheet" type="text/css" href="wall.css">
        <script type="text/javascript" src="../../functions/post/post.js"></script>
        <script type="text/javascript" src="wall.js"></script>
        <script type="text/javascript" src="profile.js"></script>
        <?php 
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="container">
            <form class="messageForm" id="messageForm0">
                <textarea class="messageFormText" id="messageFormText0" name="message_string" placeholder="Post a message to your wall here..."></textarea>
                <div class="messageFormLinks">
                    <button class="messageFormLink messageFormUploadPictureButton" value="0">Upload a picture</button>
                    <span class="messageFormPictureName" id="messageFormPictureName0"></span>
                    <input class="messageFormPicture" id="messageFormPicture0" type="file" name="photo_content"></input>
                    <button class="messageFormLink messageFormSubmitButton" value="0">Post this!</button>
                </div>
            </form>
            <hr style="width:80%">
            <div id="wall"></div>
        </div>
    </body>
</html>