<?php

echo ('
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

                $("#showRightPush").click(function () {
                    $("#showRightPush").toggleClass("clicked");
                });
            });

/*
            $(document).click(function(e) {
              if(e.target.class!="panel"){
                $(".panel").hide(500);
                $("#showAllResults").hide(500);
              }
            });
*/

        </script>
	');

?>