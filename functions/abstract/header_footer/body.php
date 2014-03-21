<?php

echo ('
    </head>
    <body class="cbp-spmenu-push">
    
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <h3>Menu</h3>
            <a href="#" onclick="myProfile()">My Profile</a>
            <a href="#" onclick="myMessages()">My Messages</a>
            <a href="#" onclick="myAlbums()">My Albums</a>
            <a href="#" onclick="myFriends()">My Friends</a>
            <a href="#" onclick="myGroups()">My Groups</a>
        </nav>
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
            <h3>Menu</h3>
            <a href="#" onclick="settings()">Settings</a>
            <a href="#">Privacy</a>
            <a href="#">Help</a>
            <a href="#">About</a>
        </nav>
        
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
                $("#results-user").on("click","#usersmallpanel",function () {
                    var user_id=this.getAttribute("value");
                    Session.set("userWall_id", user_id);
                    window.location.assign("../../pages/profile/profile.php");
                });

                $("#results-group").on("click","#groupsmallpanel",function () {
                    var group_id=this.getAttribute("value");
                    window.location.assign("../../pages/groups/groups.php");
                });
                
                $("#results-user").html("");
                $("#results-group").html("");
                $("#showAllResults").hide();
                $("#searchbar").keyup(function(){
                    if(Session.get("search") === undefined)
                    {
                        Session.set("search", $("#searchbar").val()); 
                        if(Session.get("search") != undefined){
                            $("#results-user").empty();
                            $("#results-group").empty();
                            userSearch(Session.get("search"));
                            groupSearch(Session.get("search"));
                        }else{
                            Session.set("search", ""); 
                            $("#results-user").empty();
                            $("#results-group").empty();
                            $("#showAllResults").hide();
                        }
                    }
                    else
                    {
                        Session.set("search", "");
                    }
                });
            });
            


            $(document).click(function(e) {
              if(e.target.class!="panel"){
                $("#userpanel").hide(500);
                $("#grouppanel").hide(500);
                $("#showAllResults").hide(500);
              }
            });
            
            function myProfile()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/profile/profile.php");
            }
            
            function myMessages()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/messages/messages.php");
            }

            function myAlbums()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/albums/albums.php");
            }

            function myFriends()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/friends/friends.php");
            }

            function myGroups()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/groups/groups.php");
            }

            function settings()
            {
                Session.set("userWall_id", Session.get("user_id"));
                Session.set("groupWall_id", "");
                window.location.replace("../../pages/settings/settings.php");
            }

        </script>
	');

?>