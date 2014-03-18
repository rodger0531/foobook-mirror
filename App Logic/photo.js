$(document).ready(function()
{
    alert("jjj");
	Session.set('user_id', 1);
	ajax(
		'viewCollection',
		{'user_id' : Session.get('user_id')},
		readCollectionList
	);

	// $("#addCollection").on('submit', function(event)
 //    {
 //        event.preventDefault();
 //        ajax(
 //            'createCollection',                        
 //            {'user_id' : Session.get('user_id'), 'collection_name' :document.forms["addCollection"]["collection_name"].value},   
 //            createCollectionSuccess
 //        );
 //    });

 //    $("#deleteCollection").on('click',function(){
 //        ajax(
 //            'deleteCollection',                        // PHP file to call on.
 //            {'collection_id': $("#collectionList").val()},    // Data from serialised form with user input.
 //            deleteCollectionSuccess                       // Callback method to use on success.
 //        );
 //    });

 //    $("#collectionList").on('change',function(){
 //        loadPhoto($(this).val());
 //    });

    // $(".photo").on('click', function(){
    // 	var photo_id = $(this).attr('name');
    // 	alert(photo_id);
    // });

});

function readCollectionList(data)
{
    // alert(data);
	// if(data.outcome !== 0)
	// {
	// 	$("#collection-list").append('<option value = NULL > Select a collection </option>');
	//     data.forEach(function(element){
	//         $("#collection-list").append(  '<div class="collections">' +
 //                                                '<div class="collection-image" name="' + element.collection_id +'">' +
 //                                                    '<img id="image" src="data:image/jpeg;base64,'+ element.photo_content + '">' +
 //                                                '</div>' +
 //                                                '<div class="collection-name">' +
 //                                                    '<label>' + element.collection_name + '</label>' +
 //                                                '</div>'+
 //                                            '</div>'
 //                );
	//     });
	// }
	
}

// function createCollectionSuccess(data)
// {
// 	if(data.outcome !== 0)
// 	{
// 		alert("Created collection successfully");
//     	location.reload();
// 	}
// }

// function deleteCollectionSuccess(data)
// {
// 	if(data.outcome !== 0)
// 	{
// 		alert("Deleted collection successfully");
//     	location.reload();
// 	}
// }

// function loadPhoto(collection_id)
// {
//     if (collection_id !== "NULL"){
//         ajax(
//             'viewCollectionPhoto',                       // PHP file to call on.
//             {'collection_id': collection_id},  // User_id from session goes here
//             loadPhotoSuccess                    // Callback method to use on success.
//         );
//     }
        
// }

// function loadPhotoSuccess(data)
// {
// 	if(data.outcome !== 0)
// 	{
// 		data.forEach(function(element){
// 			$('#collectionPhoto').append('<img class="photo" name="'+ element.photo_id +'" style="width:206px; height:206px; float:left;" src="data:image/jpeg;base64,'+ element.photo_content +'">');
// 		});
// 	}
// }