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
        <link rel="stylesheet" type="text/css" href="details.css">
        <link rel="stylesheet" type="text/css" href="friendList.css">
        <link rel="stylesheet" type="text/css" href="../../functions/post/post.css">
        <link rel="stylesheet" type="text/css" href="wall.css">
        <script type="text/javascript" src="../../functions/post/post.js"></script>
        <script type="text/javascript" src="wall.js"></script>
        <script type="text/javascript" src="friendRequest.js"></script>
        <script type="text/javascript" src="friendList.js"></script>
        <script type="text/javascript" src="container.js"></script>
        <script type="text/javascript" src="details.js"></script>
        <script type="text/javascript" src="profile.js"></script>
        <?php
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="panel panel-default" id="profile_details_panel">
            <div class="panel-heading" id="profile_name"></div>
            <div class="panel-body">
                <div class="panel panel-default" id="profile_picture_container"></div>
                <ul class="list-group" id="profile_details"></ul>
            </div>
        </div>
        <div class="container"></div>
        <div class="panel panel-default" id="friend_list_panel">
            <div class="panel-heading">Friends</div>
            <ul class="list-group" id="friend_list"></ul>
        </div>
    </body>
</html>