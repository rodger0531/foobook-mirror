<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
    <?php 
      require_once '../../functions/abstract/header_footer/header.php';
    ?>
    <meta name="description" content="Friends" />
    <title> FooBook - Friends </title>
    <link rel="stylesheet" type="text/css" href="friends.css">
    <script type="text/javascript" src="friends.js"></script>
    <script type="text/javascript" src="friendList.js"></script>
    <script type="text/javascript" src="circle.js"></script>
    <!-- // <script type="text/javascript" src="jquery.cbpNTAccordion.js"></script> -->
    <?php 
      require_once '../../functions/abstract/header_footer/body.php';
    ?>
      <div class="container">
        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">Friends</h3>
          </div>
          <div class="panel-body">
            <ul class="cbp-rfgrid" id="friendslist">

            </ul>
          </div>
        </div>

        <div class="panel panel-warning">
          <div class="panel-heading">
            <h3 class="panel-title">Circles</h3>
          </div>
          <div class="panel-body">

            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Select a circle <span class="caret"></span>
              </button></br>
              <ul class="dropdown-menu" role="menu" id="circleList">

              </ul>

            </div>
            <div id="friendCircleList">
            </div>

            <form id="addFriendToCircle">
              <h2>Enter friend id to add to circle</h2>
              <input type="text" name="friend_id"/><br>
              <input type="submit" name="submit" class="btn btn-success" value="Add">
            </form>

          </div>
        </div>


        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Friend Requests</h3>
          </div>
          <div class="panel-body">
            Panel content
          </div>
        </div>


        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Friend Blocks</h3>
          </div>
          <div class="panel-body">
            Panel content
          </div>
        </div>


      </div>
    </body>
</html>