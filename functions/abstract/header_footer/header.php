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
<script type="text/javascript" src="../../functions/search/search.js"></script>
<script src="../../js/modernizr.custom.js"></script>
<script src="../../js/classie.js"></script>
    
<div>
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>


          <div id="menucontainer">
            <button type="button" id="showLeftPush" class="btn btn-lg">
              <span class="glyphicon glyphicon-th-list"></span>
            </button>
          </div>
          <div id="logocontainer">
            <img id="logo" src="../../functions/abstract/header_footer/logo.png"/>
          </div>
          
          <script>
            $("#logocontainer").on("click","#logo",function(){
              window.location.assign("../homepage/homepage.php"); 
            });
          </script>

      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <form class="navbar-form navbar-left" role="search">
          
          <div class="form-group" id="searchbardiv">
            <input type="text" class="form-control" placeholder="Search for people or groups"  id="searchbar">
            <a href="../../pages/search/advancedSearchPage.php" id="search_button">Advanced search</a>
          </div>
          
          <div id="results-box">
                <div id="results">
                  <div id="results-user"></div>
                  <div id="results-group"></div>
                </div>
                
                  <div class="panel-heading" id="showAllResults">
                    <h3 class="panel-title">
                      <a href="../../pages/search/allResults.php" style="text-decoration: none; color:black;">View all results</a>
                    </h3>
                  </div>
               
            </div>
        </form>
        <div id="rightHandSideButtons">
          <ul class="nav navbar-nav">
            <li><a href="#" onclick="signOut()" id="logOut">Log Out</a></li>
          </ul>
          <ul class="nav navbar-nav">
            <li><a href="#" id="showRightPush">Settings</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</div> 
');

?>