$(document).ready(function()
{
	$('#advancedSearch').click(function(){
		if($('#job').val() === "" && $('#school').val() === "" && $('#city').val() === "" && $('#country').val() === "")
		{
			alert("Please enter a search parameter...");			
		}
		else
		{
			var job = $('#job').val();
			var school = $('#school').val();
			var city = $('#city').val();
			var country = $('#country').val();

			ajax(
				'pages/search/advancedSearch',
				{
					'job' : job,
					'school' : school,
					'city' : city,
					'country' : country
				},
				successCallbackAllUser
			);
		}
		
	});

	$('#all-users').on('click','.users',function () {
        var user_id = this.getAttribute('value');
        window.location.assign('profile.html');
        alert(user_id);
    });
});

function successCallbackAllUser(data)
{
    if(data.outcome != 0){
        $('#all-users').html('<div class="panel panel-info"><div class="panel-heading"><h3 class="panel-title">People</h3></div><div class="panel-body" id="showResults"></div></div>');
        data.forEach(function(element){
            $('#showResults').append(   '<div class="users" value="'+ element.user_id +'">'+ 
                                                '<a href="#" style="text-decoration: none">' + 
                                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '" />' + 
                                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                                '</a>' +
                                            '</div>' 
                                            
                            );
        });
    }
    else
    {
    	$('#all-users').html('<div class="not-found"><label><h1 id="not-found">No results found</h1></label><div>');
    }	
}

function profiles()
{
	$('.users').click(function(){
        var name = $(this).attr('name'); // alerts the user_id of the profile selected (used only for test purposes -- will be removed later)
        // window.location.assign("profile.html");
        alert(name);
    });
}

	


