<?php

include('connect.php');


if(isset($_POST['submit_image']))
{
	$dates=@$_POST["Date"];
	$sizes=@$_POST["Size"];
	$latitudes=@$_POST["Latitude"];
	$longitudes=@$_POST["Longitude"];
	$user_id = 1;
	$content = $_POST['content'];
	$query = mysqli_query($con, "insert into posts (user_id, content) values('$user_id', '$content')") or die(mysqli_error($con));
	$id=0;
	if($query)
	{
			$q=mysqli_query($con,"select `post_id` from posts order by `post_id` desc LIMIT 1");
			if($row=mysqli_fetch_array($q))
			{
				$id=$row[0];
			}

	}
	

	


	if($id!=0)
	{
		for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
		{
		 $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
		 $directory="images/".$_FILES["upload_file"]["name"][$i];
			if( move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], $directory))
			{
				$query = @mysqli_query($con, "INSERT INTO `files`(`post_id`, `file`, `image_lat`, `image_long`, `date`, `size`, `album_id`) VALUES ('$id','$directory','$latitudes[$i]','$longitudes[$i]','$dates[$i]','$sizes[$i]','1')") or die(mysqli_error($con));
			}
		 	
		}

	}
	
//CREATE IMAGES IN FOLDERS
	

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

</head>
<body>
	
<!-- ============NOTIFICATION WORK START============= -->
<div class="header">
	 <nav class="navbar navbar-inverse">
    <div class="container-fluid">
     <div class="navbar-header">
      <a class="navbar-brand" href="#">YOUR NOTIFICATION</a>
     </div>
     <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu"></ul>
      </li>
     </ul>
    </div>
   </nav>
</div>
<!-- ============NOTFICATION WORK END============= -->
<div class="container" style="width: 600px; margin: auto;">
	<div class="card text-center">
	  <div class="card-header">
	    ADD POSTS
	  </div>
	  <form id="myform" action="addpost.php" method="post" enctype="multipart/form-data">
		  <div class="card-body" style="margin: auto !important; width: fit-content">
		  	<div id="image_preview" style="margin: auto;"></div><br><br>
		  </div><br>
		  <div class="card-body">
		  	<div id="wrapper">
				  <input type="file" accept="Image/jpeg" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/>
				  
			 
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
	    	<!-- <br>
			<div class="row pl-3">
	  			<input type="date" value="<?php echo date_format(date_create($date),"Y-m-d");?>">
		  	</div> -->
		  	<div id="div_controls">
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
  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
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
div.innerHTML+='<input class="form-control" type="text" name="Latitude[]" value="'+item.latitude+'"><br><input class="form-control" type="text" name="Longitude[]" value="'+item.longitude+'"><br><input class="form-control" type="text" name="Date[]" value="'+item.date+'"><br><input class="form-control" type="text" name="Size[]" value="'+item.size+'"><br><hr>';
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

    // ============NOTIFICATION WORK============

$.ajax({
   url:"fetchnoti.php",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });

  });
</script>