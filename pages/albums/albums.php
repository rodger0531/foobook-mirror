<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>		
		<title>Foobook - Albums</title>
		<link rel="stylesheet" type="text/css" href="albums.css">
		<script src="albums.js"></script>
		<?php 
        require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="container">
			<div class="collection-container">
				<div class="collection-label">
					<label><h3><strong class="photo-labels">Collections</strong></h3></label>
				</div>
				<div class="collection-list">
					<div class="createCollection"><h1 class="plus">+</h1></div>
				</div><!-- /.collection-list -->
			</div><!-- /.collection-container -->
					   
		    <form method="post" id="newCollection">
				<input type="text" class="form-control" id="collection-name" name="collection_name" placeholder="Collection name">
				<input type="file" id="photo-content-collection" name="photo_content">
				<input type="submit" class="btn btn-success" id="btnCreate" name="submit" value="Create">
				<button type="button" class="btn btn-warning" id="cancelCollection">Cancel</button>
			</form>
				
			<form method="post" id="newPhoto">
				<input type="file" id="photo-content-photo" name="photo_content">
				<input type="submit" class="btn btn-success" id="btnUpload" name="submit" value="Upload">
				<button type="button" class="btn btn-warning" id="cancelPhoto">Cancel</button>
			</form>

			<div class="photo-container">
				<div class="photo-label">
					<label><h3><strong class="photo-labels">Photos</strong></h3></label>
					<button class="btn btn-danger" id="deleteCollection">Delete Collection</button>
					<button class="btn btn-danger" id="deletePhoto">Delete Photo</button>
				</div>
				<div class="photo-list">
					<div class="uploadPhoto"><h1 class="plus">+</h1></div>
				</div><!-- /.photo-list -->
			</div><!-- /.photo-container -->	
		</div><!-- /.container -->
	</body>
</html>