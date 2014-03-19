$(document).ready(function()
{
	$('#newCollection').hide();
	$('#newPhoto').hide();
	$('.photo-container').hide();
	$('#deletePhoto').hide();
	Session.set('user_id', 1);
	viewCollection();
	var collection_id;
	var photo_id;

	//show new collection
	$('.collection-container').on('click', '.createCollection', function(){
		$('#newCollection').show();
	});

	//hide new collection
	$('#newCollection').on('click', '#cancelCollection', function(){
		$('#collection-name').val("");
		$('#photo-content-collection').replaceWith($('#photo-content-collection').clone( true ));
		$('#newCollection').hide();
	});

	//create new collection
	$("#newCollection").on('submit', function(event)
    {
    	// if($('#photo-content-collection').val() === "")
    	// {
    	// 	alert("Please select a photo to upload!");
    	// }
    	
    	event.preventDefault();
        var formData = new FormData($("#newCollection")[0]);
        formData.append('user_id', Session.get('user_id'));
        $.ajax(
        {
            type: 'POST',
            url: 'http://localhost/createCollection.php',
            data: formData, 
            dataType: 'JSON',
            success: newCollection,
            error: ajaxFailure,
            cache: false,
            contentType: false,
            processData: false
        });
        
    });

	// load photos in collection
	$('.collection-container').on('click', '.collections', function(){
		$('#deletePhoto').hide();
		collection_id = $(this).attr('name');
		viewCollectionPhoto(collection_id);
	});

	//show photo upload
	$('.photo-container').on('click', '.uploadPhoto', function(){
		$('#newPhoto').show();
	});

	//hide photo upload
	$('#newPhoto').on('click', '#cancelPhoto', function(){
		$('#photo-content-photo').replaceWith($('#photo-content-photo').clone( true ));
		$('#newPhoto').hide();
	});

	// upload new photo
	$("#newPhoto").on('submit', function(event)
    {
        event.preventDefault();
        var formData = new FormData($("#newPhoto")[0]);
        formData.append('collection_id', collection_id);
        $.ajax(
        {
            type: 'POST',
            url: 'http://localhost/uploadPhotoToCollection.php',
            data: formData, 
            dataType: 'JSON',
            success: uploadPhotoSuccess,
            error: ajaxFailure,
            cache: false,
            contentType: false,
            processData: false
        });
    });

	//delete Collection
	$('.photo-container').on('click', '#deleteCollection', function(){
		ajax(
			'deleteCollection',
			{'collection_id' : collection_id},
			deleteCollectionSuccess
		);
	});

	//
	$('.photo-container').on('click', '.photos', function(){
		$('#deletePhoto').show();
		photo_id = $(this).attr('name');
	});

	//delete photo
	$('.photo-container').on('click', '#deletePhoto', function(){
		ajax(
			'deletePhoto',
			{'photo_id' : photo_id},
			deletePhotoSuccess
		);
	});


});

function viewCollection()
{
	ajax(
		'viewCollection',
		{'user_id' : Session.get('user_id')},
		collectionList
	);

}

function collectionList(data)
{
	if(data.outcome !== 0)
	{
		$('.collection-list').html('<div class="createCollection"><h1 class="plus">+</h1></div>');
	    data.forEach(function(element){
	        $('.collection-list').append(  '<div class="collections" name="' + element.collection_id +'">' +
                                                '<div class="collection-image">' +
                                                    '<img id="image" src="data:image/jpeg;base64,'+ element.photo_content + '">' +
                                                '</div>' +
                                                '<div class="collection-name">' +
                                                    '<label>' + element.collection_name + '</label>' +
                                                '</div>'+
                                            '</div>'
                );
	    });
	}
	
}

function newCollection(data)
{
	$('#collection-name').val("");
	$('#photo-content-collection').replaceWith($('#photo-content-collection').clone( true ));
	$('#newCollection').hide();
	viewCollection();
}

function viewCollectionPhoto(collection_id)
{
	var collection_id = collection_id;
	ajax(
			'viewCollectionPhoto',
			{'collection_id' : collection_id},
			viewCollectionPhotoSuccess
		);
}

function viewCollectionPhotoSuccess(data)
{
	if(data.outcome !== 0)
	{
		$('.photo-container').show();
		$('.photo-list').html('<div class="uploadPhoto"><h1 class="plus">+</h1></div>');
	    data.forEach(function(element){
	        $('.photo-list').append( '<div class="photos" name="'+ element.photo_id +'">' +
										'<img class="photo-image" src="data:image/jpeg;base64,'+ element.photo_content + '">' +
									'</div>'
                );
	    });
	}
}

function uploadPhotoSuccess(data)
{
	viewCollectionPhoto(data);
	viewCollection();
	$('#photo-content-photo').replaceWith($('#photo-content-photo').clone( true ));
	$('#newPhoto').hide();
}

function deleteCollectionSuccess(data)
{
	viewCollection();
	$('.photo-container').hide();
}

function deletePhotoSuccess(data)
{
	viewCollectionPhoto(data);
	viewCollection();
	$('#deletePhoto').hide();
}