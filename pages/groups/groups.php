<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
        <?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>
        <meta name="description" content="Foobook is a social networking website." />
        <meta name="keywords" content="Foobook, Social Network">
        <title>Foobook</title>
        <link rel="stylesheet" type="text/css" href="groups.css">
        <link rel="stylesheet" type="text/css" href="memberList.css">
        <link rel="stylesheet" type="text/css" href="../../functions/post/post.css">
        <link rel="stylesheet" type="text/css" href="wall.css">
        <script type="text/javascript" src="../../functions/post/post.js"></script>
        <script type="text/javascript" src="wall.js"></script>
        <script type="text/javascript" src="addMember.js"></script>
        <script type="text/javascript" src="memberList.js"></script>
        <script type="text/javascript" src="container.js"></script>
        <script type="text/javascript" src="details.js"></script>
        <script type="text/javascript" src="groups.js"></script>
        <?php
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="container"></div>
        <div class="panel panel-default" id="member_list_panel">
            <div class="panel-heading" id="group_name"></div>
            <div class="panel-heading">Members</div>
            <ul class="list-group" id="member_list"></ul>
        </div>
    </body>
</html>