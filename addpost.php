<?php

include('connect.php');

$date = '';


if(isset($_POST['submit_image']))
{
	// WILL SHOW THE IMAGE OF SINGLE IMAGE

	if(is_array($_FILES)) {
	@$image_properties = exif_read_data($_FILES['upload_file']['tmp_name'][0]);
	print "<PRE>";
		@$date = $image_properties['DateTime'];
	// print_r($image_properties);
	print "</PRE>";
	}

	$count = 0;
	// TO GET THE IMAGE SIZE
	for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
	{
		@$image_properties = exif_read_data($_FILES['upload_file']['tmp_name'][$i]);
		@$count += $image_properties['FileSize']/1000;
	}

	echo $count;



	//IMAGE LOCATION WORK
	function get_image_location($image = ''){
	    @$exif = exif_read_data($image, 0, true);
	    if($exif && isset($exif['GPS'])){
	        @$GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
	        @$GPSLatitude    = $exif['GPS']['GPSLatitude'];
	        @$GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
	        @$GPSLongitude   = $exif['GPS']['GPSLongitude'];
	        
	        @$lat_degrees = count($GPSLatitude) > 0 ? gps2Num($GPSLatitude[0]) : 0;
	        @$lat_minutes = count($GPSLatitude) > 1 ? gps2Num($GPSLatitude[1]) : 0;
	        @$lat_seconds = count($GPSLatitude) > 2 ? gps2Num($GPSLatitude[2]) : 0;
	        
	        @$lon_degrees = count($GPSLongitude) > 0 ? gps2Num($GPSLongitude[0]) : 0;
	        @$lon_minutes = count($GPSLongitude) > 1 ? gps2Num($GPSLongitude[1]) : 0;
	        @$lon_seconds = count($GPSLongitude) > 2 ? gps2Num($GPSLongitude[2]) : 0;
	        
	        @$lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
	        @$lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
	        
	        $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
	        $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

	        // return array('latitude'=>$latitude, 'longitude'=>$longitude);
	        return array('latitude'=>$latitude, 'longitude'=>$longitude);
	    }else{
	        return false;
	    }
	}

	function gps2Num($coordPart){
	    $parts = explode('/', $coordPart);
	    if(count($parts) <= 0)
	    return 0;
	    if(count($parts) == 1)
	    return $parts[0];
	    return floatval($parts[0]) / floatval($parts[1]);
	}

	$imageURL = $_FILES['upload_file']['tmp_name'][0];
	//get location of image
	$imgLocation = get_image_location($imageURL);

	//latitude & longitude
	// $imgLat = $imgLocation['latitude'];
	// $imgLng = $imgLocation['longitude'];
	// print_r($imgLocation);

//CREATE IMAGES IN FOLDERS
	for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
	{
	 $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
	 $folder="images/";
	 move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "$folder".$_FILES["upload_file"]["name"][$i]);
	}

}


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

</head>
<body>
	
<div id="ajax"></div>
<div class="container" style="width: 600px; margin: auto;">
	<div class="card text-center">
	  <div class="card-header">
	    ADD POSTS
	  </div>
	  <form id="myform" action="upload.php" method="post" enctype="multipart/form-data">
		  <div class="card-body" style="margin: auto !important; width: fit-content">
		  	<div id="image_preview" style="margin: auto;"></div><br><br>
		  </div><br>
		  <div class="card-body">
		  	<div id="wrapper">
				  <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/>
				  
			 
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
	  			<input type="date" value="<?php echo date_format(date_create($date),"Y-m-d");?>">
		  	</div>
	<br>
			<div class="row">
				<label>Location</label>
				<input type="text" name="" class="form-control">
			</div>
			<br>
		  	<div class="row">
		  		<div id="map"></div>	
		  	</div>
		    <div class="row">
		    	<label>Add Text</label>
		    	<textarea name="content" class="form-control ml-2 mr-2">
		    		
		    	</textarea>
		    </div>
		    <br>
		    <input type="submit" class="btn btn-primary" name='submit_image' value="Upload Image"/>
		  </div>

<div id="div_controls">
	

</div>

	  </form>
	  <div class="card-footer text-muted">
	    2 days ago
	  </div>
	</div>
</div>
<!-- ========================= -->


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

 $('#upload_file').on("change", function(){
 	//$("#myform").submit();
 	// $("#myform").preventDefault();
 	var frm=document.getElementById('myform');
        var formData = new FormData(frm);

        $.ajax({
            type:'POST',
            url: "upload.php",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
var div=document.getElementById('div_controls');
div.innerHTML="";
var d=JSON.parse(data);
// alert(d);
               d.forEach(function(item){
div.innerHTML+='<input type="text" name="Latitude[]" value="'+item.latitude+'"><br><input type="text" name="Longitude[]" value="'+item.longitude+'"><br><input type="text" name="Date[]" value="'+item.date+'"><br><input type="text" name="Size[]" value="'+item.size+'"><br><hr>';
alert(item.latitude);
               }); 	
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
 });

</script>

<script type="text/javascript">
	var myCenter = new google.maps.LatLng(<?php echo $imgLocation['latitude']; ?>, <?php echo $imgLocation['longitude']; ?>);
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
</script>