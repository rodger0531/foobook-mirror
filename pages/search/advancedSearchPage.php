<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
        <?php 
          require_once '../../functions/abstract/header_footer/header.php';
        ?>
        <title>Foobook</title>
        <link rel="stylesheet" type="text/css" href="advancedSearch.css">
        <script type="text/javascript" src="advancedSearch.js"></script>
        <?php 
          require_once '../../functions/abstract/header_footer/body.php';
        ?>
        <div class="container">
            <div class="advanced-search-fields">
                <input class="form-control" id="job" placeholder="Search by job">
                <input class="form-control" id="school" placeholder="Search by school">
                <input class="form-control" id="city" placeholder="Search by city">
                <input class="form-control" id="country" placeholder="Search by country">
                <button type="button" class="btn btn-info" id="advancedSearch">Advanced search</button>
            </div>

            <div id="all-results">
                <div id="all-users"></div>
            </div>
        </div>
    </body>
</html>