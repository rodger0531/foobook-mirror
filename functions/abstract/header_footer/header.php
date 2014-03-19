<?php

echo ('
	<meta charset="utf-8">
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
	<script type="text/javascript" src="../../functions/abstract/session.js"></script>
    <script type="text/javascript" src="../../functions/abstract/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="../../functions/abstract/header_footer/header.css">
    <link rel="stylesheet" type="text/css" href="../../css/default.css">
    <link rel="stylesheet" type="text/css" href="../../css/component.css">
    <script src="../../js/modernizr.custom.js"></script>
    <script src="../../js/classie.js"></script>
    
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
    
	');

?>