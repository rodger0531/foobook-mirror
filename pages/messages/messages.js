$(document).ready(function(){

    var user_id = Session.get('user_id'); //For testing purposes I need to create a user.
    var threadName;
    loadThreads(user_id);
    function loadThreads(user_id)
    {
        ajax(
        'pages/messages/thread',
        {
            'session' : user_id
        },
        threadSuccess
        );
    }

    //Controls the clicking on a specific thread.
    $('.threads').on('click', '.thread_elements', function()
    {   
        $('#participants_inputField').remove();
        threadName = $(this).attr('name');
        
        ajax(
            'pages/messages/viewThreadMessage',
            {
                'thread_id' : threadName
            },
            loadThreadOnClickSuccess
        );
    });
    
    $('#compose_message_id').click(function(){
        $('.participant').empty();
        $('.inner_wrap_messages').html("");
        $('.participants_container').html("");
        var participantInput = '<input type="text" id="participants_inputField" size="30">';
        $('.participants_container').append(participantInput);
    });

    //Controls the clicking on Send button.
    $('#reply_button').click(function(){
       if($('#textbox_id').val() !== "")
        {
            if($('#participants_inputField').length === 0)
            {
                var message_string = $('#textbox_id').val();
                var sender_id = Session.get('user_id');
                var thread_id;
                
                if(threadName === undefined)
                {
                    thread_id = $('.participant').attr('name');
                }
                else
                {
                    thread_id = threadName;
                }
                
                ajax(
                    'pages/messages/composeThread',
                    { 'thread_id' : thread_id,
                      'sender_id' : sender_id,
                      'message_string' : message_string
                    },
                    loadThreadSuccess
                ); 
                
                $('#textbox_id').val("");

                ajax(
                    'pages/messages/thread',
                    {
                        'session' : sender_id
                    },
                    threadSuccess
                );
            }
            else if($('#participants_inputField').length > 0)
            {   
                var sender_id = Session.get('user_id');
                var recipient_id = $('#participants_inputField').val();
                var message_string = $('#textbox_id').val();
                
                ajax(
                    'pages/messages/composeThread',
                    {
                        'sender_id' : sender_id,
                        'recipient_id' :recipient_id,
                        'message_string' : message_string
                    },
                    composeThreadSuccess
                );
            }
        }        
    });
});

    function threadSuccess(data)
    {
        $(".threads").html("");

        data.forEach(function(element)
        {
            $('.threads').append(
                '<div class="thread_elements" name="'+ element.thread_id +'">' +
                    '<div class="thread_picture">' +
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="picture">' +
                    '</div>' +
                    '<div class="thread_name">' +
                        '<span>' + element.thread_name + '</span>'+'</a>'+
                    '</div>' + 
                    '<div class="thread_message">' + element.message_string +'</div>' +
                    '<div class="thread_timestamp">' + element.created + '</div>' +
                '</div>'
            );
           
        });

        loadLatestThread(data[0].thread_id);
    }
    function threadSuccessOnCompose(data)
    {
        data.forEach(function(element)
        {
            $('.threads').append(
                '<div class="thread_elements" name="'+ element.thread_id +'">' +
                    '<div class="thread_picture">' +
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="picture">' +
                    '</div>' +
                    '<div class="thread_name">' +
                        '<span>' + element.thread_name   + '</span>'+'</a>'+
                    '</div>' +
                    '<div class="thread_message">' + element.message_string + '</div>' +
                    '<div class="thread_timestamp">' + element.created + '</div>' +
                '</div>'
            );
        });
        location.reload();
    }

    function loadLatestThread(latest_id)
    {
        var latestThread = latest_id;
        ajax (
        'pages/messages/viewThreadMessage',
        {
            'thread_id' : latestThread 
        },
        loadThreadSuccess
        );
    }
    function loadThreadSuccess(data)
    {  
        $('.inner_wrap_messages').html("");
        //To dymanically generate the participant/s name/s in the participant/s container.
        $('participants_container').html(""); 
        $('.participant').empty();
        var threadParticipants = '<div class="participant" name="'+ data[0].thread_id +'">' + data[0].thread_name + '</div>';
        $('.participants_container').append(threadParticipants);
        var participantMessage = "";
        var currentUserMessage = "";
        var latestMessage = "";

        data.forEach(function(element){
            /*If the user_id does not match the session id then it is considered as a actor other than the current user and a 
            * a special <div> is being generated for this purpose.
            */
            if(element.sender_id === "1")
            {   
                currentUserMessage =
                '<div class="user_message" id="' + element.message_id + '">' +
                    '<div class="user_name">' + element.first_name +' '+ element.last_name + '</div>' +
                    '<div class="user_pic">' +
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="user_picture"/>' +
                    '</div>' +
                    '<div class="message_body_user">' +
                        '<div class="message_content_user">' + element.message_string + '</div>' +
                        '<div class="message_timestamp_user">' + element.created + '</div>' +
                    '</div>' +
                '</div>' + '<br style="clear: both">';
                
                $('.inner_wrap_messages').append(currentUserMessage);
            }
            /* If there is a match it will be considered as the actual user and a respective div is generated.*/
            else
            {   
                participantMessage = 
                '<div class="participant_message" id="' + element.message_id + '">' + 
                '<div class="participant_name">' + element.first_name +' '+ element.last_name + '</div>' +
                    '<div class="participant_pic">' + 
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="participant_picture"/>' +
                    '</div>' +
                    '<div class="message_body_participant">' +
                        '<div class="message_content_participant">' + element.message_string + '</div>' +
                        '<div class="message_timestamp_participant">' + element.created +'</div>' +
                    '</div>' +
                '</div>' + '<br style="clear: both">';

                $('.inner_wrap_messages').append(participantMessage);

            }
            latestMessage = element.message_id;
        });
        $('.inner_wrap_messages').animate({scrollTop: $('#' + latestMessage).offset().top}, 20);
    }
   
    function loadThreadOnClickSuccess(data)
    {   
        var latestMessage = "";
        $('.inner_wrap_messages').html("");
        //To dymanically generate the participant/s name/s in the participant/s container.
        $('participants_container').html(""); 
        $('.participant').empty();
        var threadParticipants = '<div class="participant" name="'+ data[0].thread_id +'">' + data[0].thread_name + '</div>';
        $('.participants_container').append(threadParticipants);
        var participantMessage = "";
        var currentUserMessage = "";
     
        data.forEach(function(element){

            /*If the user_id does not match the session id then it is considered as a actor other than the current user and a 
            * a special <div> is being generated for this purpose.
            */
            if(element.sender_id === "1")
            {   
                currentUserMessage =
                '<div class="user_message" id="' +element.message_id+ '">' +
                '<div class="user_name">' + element.first_name +' '+ element.last_name + '</div>' +
                    '<div class="user_pic">' +
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="user_picture"/>' +
                    '</div>' +
                    '<div class="message_body_user">' +
                        '<div class="message_content_user">' + element.message_string + '</div>' +
                        '<div class="message_timestamp_user">' + element.created + '</div>' +
                    '</div>' +
                '</div>' + '<br style="clear: both">';
                
                $('.inner_wrap_messages').append(currentUserMessage);

            }
            /* If there is a match it will be considered as the actual user and a respective div is generated.*/
            else
            {   
                participantMessage = 
                '<div class="participant_message" id="' +element.message_id+ '">' + 
                '<div class="participant_name">' + element.first_name +' '+ element.last_name + '</div>' +
                    '<div class="participant_pic">' + 
                        '<img src="data:image/jpeg;base64,' + element.photo_content + '" class="participant_picture"/>' +
                    '</div>' +
                    '<div class="message_body_participant">' +
                        '<div class="message_content_participant">' + element.message_string + '</div>' +
                        '<div class="message_timestamp_participant">' + element.created +'</div>' +
                    '</div>' +
                '</div>' + '<br style="clear: both">';

                $('.inner_wrap_messages').append(participantMessage);

            }
            latestMessage = element.message_id;
        });
        $('.inner_wrap_messages').animate({scrollTop: $('#' + latestMessage).offset().top}, 20);
    }

    function composeThreadSuccess(data)
    {
        $('.inner_wrap_messages').html("");
        $('#participants_inputField').remove();
        $('participants_container').html(""); 
        var threadParticipants = '<div class="participant">' + data[1].thread_name + '</div>';
        $('.participants_container').append(threadParticipants);
    
        var currentUserMessage = "";

        currentUserMessage =
        '<div class="user_message">' +
        '<div class="user_name">' + data[0].first_name +' '+ data[0].last_name + '</div>' +
            '<div class="user_pic">' +
                '<img src="data:image/jpeg;base64,' + data[0].photo_content + '" class="user_picture"/>' +
            '</div>' +
            '<div class="message_body_user">' +
                '<div class="message_content_user">' + data[0].message_string + '</div>' +
                '<div class="message_timestamp_user">' + data[0].created + '</div>' +
            '</div>' +
        '</div>' + '<br style="clear: both">';
        
        $('.inner_wrap_messages').append(currentUserMessage);

        var sender_id = Session.get('user_id');
        $('#textbox_id').val("");
        $(".threads").html("");
        
        ajax(
            'pages/messages/thread',
            {
                'session' : sender_id
            },
            threadSuccessOnCompose
        );
    }