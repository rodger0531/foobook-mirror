<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>
		<meta name="description" content="Bla bla" />
		<meta name="keywords" content="Bla bla">
		<title>Profile</title>
        <link rel="stylesheet" type="text/css" href="messages_style.css">
        <script type="text/javascript" src="messages.js"></script>
        <?php 
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="container">
            <div class="wrapper">
                <div class="inner_wrapper_content" value="">
                    <div class="left_sidebar_thread" id="left_sidebar_thread_id">
                        <div class="wrapper_search">
                            <div class="search_message" id="search_message_id">
                                <input type="text" id="search_bar_message" size="38">
                            </div>
                            <div class="compose_message">
                                <button type="button" class="glyphicon glyphicon-plus" id="compose_message_id"> Compose:</button>
                            </div>
                        </div>
                        <div class="threads" id="threads_id">
                        </div>
                    </div>
                    <div class="content" id="content_id">
                        <div class="content_wrapper" id="content_wrapper_id">
                            <div class="participants_wrapper" id="participants_wrapper_id">
                                <div class="participants" id="participants_id">
                                    <div class="participants_input_wrapper" id="participants_input_wrapper_id">
                                        <p id="participant_to">To:</p>
                                        <div class="participants_container" id="participants_container_id"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="messages" id="messages_id">
                                <div class="inner_wrap_messages" id="inner_wrap_messages_id">
                                </div>
                            </div>  
                            <div class="input_area" id="input_area_id">
                                <div class="message_wrapper" id="message_wrapper_id">
                                    <div class="textbox_wrapper" id="textbox_wrapper_id">
                                        <textarea id="textbox_id" name="textbox" rows="7" cols="50"></textarea>
                                    </div>
                                </div>
                                <input type="submit" id="reply_button" value="Send">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>  
</html>