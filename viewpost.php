<?php
include('connect.php');
$post_id=1;
$query = mysqli_query($con, "
SELECT posts.post_id, content,
GROUP_CONCAT(DISTINCT files.file_id) AS file_id,
GROUP_CONCAT(DISTINCT files.file) AS file_link, 
GROUP_CONCAT(DISTINCT files.image_lat) AS file_lat,
GROUP_CONCAT(DISTINCT files.image_long) AS file_long,
GROUP_CONCAT(DISTINCT files.date) AS file_date,
GROUP_CONCAT(DISTINCT files.size) AS file_size,
GROUP_CONCAT(DISTINCT users.user_id) AS user_id,
GROUP_CONCAT(DISTINCT users.name) AS user_name,
GROUP_CONCAT(DISTINCT post_category.category_id) AS category_id,
GROUP_CONCAT(DISTINCT post_category_cde.description) AS category_name
FROM posts 
LEFT JOIN files 
ON 
posts.post_id = files.post_id
LEFT JOIN tag_posts
ON
posts.post_id = tag_posts.post_id
LEFT JOIN users
ON
users.user_id = tag_posts.friend_id
LEFT JOIN post_category
ON
posts.post_id = post_category.post_id
LEFT JOIN post_category_cde
ON
post_category_cde.category_id = post_category.category_id
WHERE posts.post_id = '$post_id'
	");
$std=mysqli_fetch_array($query);
echo "<pre>";
print_r($std);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Posts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="src/css/coverflow.css">
	<script type="text/javascript" src="src/js/coverflow.js"></script>

</head>
<body>

<div id="ajax"></div>
<div class="container" style="width: 600px; margin: auto;">
	<div class="card text-center">
	  <div class="card-header">
	    ADD POSTS
	  </div>
	  <form id="myform" action="#" method="post" enctype="multipart/form-data">
		  <div class="card-body" style="margin: auto !important; width: fit-content">
		  	<div id="image_preview" style="margin: auto;"></div><br><br>
		  	<div class="myImages">
		  		<?php
					$images = explode(",",$std['file_link']);
					foreach($images as $image)
					{
					?>
					<img src="<?php echo "assets/".$image ?>">
					<?php
					}
				?>
		  	</div>
		  </div><br>
		  <div class="card-body">
		  	<div id="wrapper">
				  <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/>
				  
				 </form>
			 
			</div>
		  	
		  	
	<br>
		  	
	<br>
		    <div class="row">
		    	<div class="col-md-3">
	    			<h5 class="btn btn-primary" style="text-align: left;">Tag Friends</h5>
		    	</div>
		    	<div class="col-md-3 offset-6">
		    		<div class="row">
		    			<label class="mr-2">Audience</label>
			    		<select class="form-control">
			    			<option>Friends</option>
			    			<option>Just Me</option>
			    		</select>
		    		</div>
		    	</div>
		    </div><br>
		    <!-- ======AUTO COMPLETE WORK======= -->

<div class="input-group">
    <input type="text" id="search_data" placeholder="" autocomplete="off" class="form-control" />
    <div class="input-group-btn">
        <button type="button" class="btn btn-primary" id="search">Get Value</button>
    </div>
</div>
<br />
<span id="name"></span>

		    <!-- ===========AUTO COMPLETE WORK======= -->
	    	<br>
			<div class="row pl-3">
				<?php
				$date = explode(",",$std['file_date']);
				?>
	  			<input type="date" value="<?php echo date_format(date_create($date[0]),"Y-m-d");?>">
		  	</div>
	<br>
			<div class="row">
				<label>Location</label>
				<input type="text" name="" class="form-control">
			</div>
			<br>
		  	<div class="row">
		  		<div id="map"></div>	
		  	</div><br>
		    <div class="row">
		    	<label>Add Text</label>
		    	<input type="text" name="" value="<?php echo @$std['content']; ?>" class="form-control">
		    </div>
		    <br>
		    <input type="submit" class="btn btn-primary" name='submit_image' value="Upload Image"/>
		  </div>
	  </form>
	  <div class="card-footer text-muted">
	    2 days ago
	  </div>
	</div>
</div>
<!-- ========================= -->
<div id="coverflow">
    
    <div class="something_fancy"></div>
    <img src="assets/DSCN0021.jpg" />
	<img src="assets/DSCN0025.jpg" />    
    <picture><source .. /></picture>
</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB89iy-emaLpV_lr2Yu3SExadrw02-ZRaQ"></script>

<!-- ===================================== -->

<script>

$(document).ready(function() 
{ 
 $('form').ajaxForm(function() 
 {
  alert("Uploaded SuccessFully");
 }); 
});

function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img accept='Image/jpeg' src='"+URL.createObjectURL(event.target.files[i])+"'>");
 }

}

 $('#myform').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));

 $('#upload_file').on("change", function(){
 	$("#myform").submit();
 });

</script>

<script type="text/javascript">
	<?php
	$lat = explode(",",$std['file_lat']);
	$long = explode(",",$std['file_long']);
	?>
	var myCenter = new google.maps.LatLng(<?php echo $lat[0]; ?>, <?php echo $long[0]; ?>);
function initialize(){
    var mapProp = {
        center:myCenter,
        zoom:10,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map"),mapProp);

    var marker = new google.maps.Marker({
        position:myCenter,
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- =======AUTO COMPLETE======= -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<script>
  $(document).ready(function(){
      
    $('#search_data').tokenfield({
        autocomplete :{
            source: function(request, response)
            {
                jQuery.get('fetch.php', {
                    query : request.term
                }, function(data){
                    data = JSON.parse(data);
                    response(data);
                });
            },
            delay: 100
        }
    });

    $('#search').click(function(){
        $('#name').text($('#search_data').val());
    });

  });

  // ============================================
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyCqsIfD59i4qphzF-6HopqmNQ3087-olJM',
			success: function(result){
				console.log(result);
			}
		});
	});
</script>
<!-- ==================================== -->
<script src="src/js/coverflow.min.js"></script>
<script>
    $(function() {
		// and kick off
        $('#coverflow').coverflow();
    });
</script>