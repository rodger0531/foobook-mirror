$(document).ready(function(){
// function advancedSearchFunctionality(){
	
	$('#showAllResults').hide();
	$('#advancedSearchResult').html("");
	$('#advancedSearch').click(function()
	{
		$('.searchResults').remove();
		var city = $('#city').val();
		var country = $('#country').val();
		var employer = $('#employer').val();
		var school = $('#school').val();
		ajax(
			'advancedSearch',
			{city : city, country : country, employer : employer, school : school},
			advancedSearchCallback
		);
	});
// }
});

function advancedSearchCallback(data)
{
	if(data.outcome != 0){
        $('#advancedSearchResult').append('<div class="searchResults">' + '<span style="float:left; border: 1px solid green; width:100%;">'+'</span>' +'</div>');
        data.forEach(function(element){
            $('.searchResults').append(   '<div class="Users" align="left" style="border:1px solid red; height:50px; padding:20px; margin-top:-1px;"  name="'+ element.user_id +'">'+ 
                                                '<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '" style="width:50px; height:50px; float:left; margin-right:6px;" />' + 
                                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                                '</a>' +
                                            '</div>' 
                                            
                            );
        });
    }
}