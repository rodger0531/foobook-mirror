<?php

echo ('
	<meta charset="utf-8">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="session.js"></script>
    <script type="text/javascript" src="ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/component.css">
    <script src="js/modernizr.custom.js"></script>
    
    
    <div>
        <nav class="navbar navbar-default" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" id="showLeftPush" href="#" style="text-align:center">FooBook</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <form class="navbar-form navbar-left" role="search">
                <div class="form-group" id="searchbardiv">
                  <input type="text" class="form-control" placeholder="Search for people or groups"  id="searchbar">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
              </form>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#" id="showRightPush">Settings</a></li>
              </ul>
            </div>
          </div>
        </nav>
    </div> 
    
    
    
    
    </head>
    <body class="cbp-spmenu-push">
    
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <h3>Menu</h3>
            <a href="#">My Profile</a>
            <a href="#">My Albums</a>
            <a href="#">My Friends</a>
            <a href="#">My groups</a>
        </nav>
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
            <h3>Menu</h3>
            <a href="#">Settings</a>
            <a href="#">Privacy</a>
            <a href="#">Help</a>
            <a href="#">About</a>
        </nav>
        
        
        <script src="js/classie.js"></script>
        <script>
            var menuLeft = document.getElementById( "cbp-spmenu-s1" ),
                    menuRight = document.getElementById( "cbp-spmenu-s2" ),
                    showLeftPush = document.getElementById( "showLeftPush" ),
                    showRightPush = document.getElementById( "showRightPush" ),
                    body = document.body;

            showLeftPush.onclick = function() {
                classie.toggle( this, "active" );
                classie.toggle( body, "cbp-spmenu-push-toright" );
                classie.toggle( menuLeft, "cbp-spmenu-open" );
                disableOther( "showLeftPush" );
            };
            showRightPush.onclick = function() {
                classie.toggle( this, "active" );
                classie.toggle( body, "cbp-spmenu-push-toleft" );
                classie.toggle( menuRight, "cbp-spmenu-open" );
                disableOther( "showRightPush" );
            };

            function disableOther( button ) {
                if( button !== "showLeftPush" ) {
                    classie.toggle( showLeftPush, "disabled" );
                }
                if( button !== "showRightPush" ) {
                    classie.toggle( showRightPush, "disabled" );
                }
            }
            
            $( document ).ready( function(){
                $("#showLeftPush").click(function () {
                    $("#showLeftPush").toggleClass("clicked");
                });
            });
        </script>
	');

?>