<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>coverflow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
   

*, *:before, *:after {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
    font-family: 'Poppins', sans-serif;
}

.swiper-container {
	width: 100%;
	height: 28vw;
	transition: opacity .6s ease;
}

.swiper-container.swiper-container-coverflow {
	padding-top: 2%;
}

.swiper-container.loading {
	opacity: 0;
	visibility: hidden;
}

.swiper-container:hover .swiper-button-prev,
  .swiper-container:hover .swiper-button-next {
	transform: translateX(0);
	opacity: 1;
	visibility: visible;
}

.swiper-slide {
	background-position: center;
	background-size: cover;
}

.swiper-slide .entity-img {
	display: none;
}

.swiper-slide .content {
	position: absolute;
	top: 40%;
	left: 0;
	width: 50%;
	padding-left: 5%;
	color: #fff;
}

.swiper-slide .content .title {
	font-size: 2.6em;
	font-weight: bold;
	margin-bottom: 30px;
}

.swiper-slide .content .caption {
	display: block;
	font-size: 13px;
	line-height: 1.4;
}

[class^="swiper-button-"] {
	width: 44px;
	opacity: 0;
	visibility: hidden;
}

.swiper-button-prev {
	transform: translateX(50px);
}

.swiper-button-next {
	transform: translateX(-50px);
}

 
    
    </style>
</head>
<body>
   <section class="swiper-container"> 
  <div class="swiper-wrapper">
    <?php
    $query = mysqli_query($con, "select * from post_category_cde");
    while ($row=mysqli_fetch_array($query)) {
    	?>
    	<div class="swiper-slide" style="background-image:url(assets/DSCN0021.jpg)">
	      <img src="assets/DSCN0021.jpg" class="entity-img" />
	      <div class="content">
	        <p class="title" data-swiper-parallax="-30%" data-swiper-parallax-scale=".7"><?php echo $row['description'] ?></p>
	        
	        <input type="hidden" name="this_id" class="this_id" value="<?php echo $row['category_id'] ?>">
	      </div>
	    </div>
    	<?php
    }
    ?>
  </div>
  
  <!-- If we need pagination -->
  <div class="swiper-pagination"></div>
  <!-- If we need navigation buttons -->
  <div class="swiper-button-prev swiper-button-white"></div>
  <div class="swiper-button-next swiper-button-white"></div>

</section>
  <br><br><hr><br><br>
 <?php
  $query1 = mysqli_query($con, "
	SELECT *, GROUP_CONCAT(files.file) AS file_link FROM post_category_cde
	INNER JOIN post_category
	ON 
	post_category.category_id = post_category_cde.category_id
	INNER JOIN posts
	ON
	posts.post_id = post_category.post_id
	LEFT JOIN files
	ON
	files.post_id = posts.post_id
	WHERE post_category_cde.category_id = 5
	and posts.user_id = 2;
  	");

  while ($row=mysqli_fetch_array($query1)) {
	  	$images = explode(",",$row['file_link']);
			foreach($images as $image)
			{
			?>
			<div class="col-md-3">
				<img src="<?php echo $image ?>" class="img-fluid" width="200" height="200">
				<div class="row">
				</div>
			</div>

			<?php
			}
	  	?>
	
  	<?php
  }

  ?>

  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>
 <script>
    
    // Params
var sliderSelector = '.swiper-container',
    options = {
      init: false,
      loop: true,
      speed:800,
      slidesPerView: 2, // or 'auto'
      // spaceBetween: 10,
      centeredSlides : true,
      effect: 'coverflow', // 'cube', 'fade', 'coverflow',
      coverflowEffect: {
        rotate: 50, // Slide rotate in degrees
        stretch: 0, // Stretch space between slides (in px)
        depth: 100, // Depth offset in px (slides translate in Z axis)
        modifier: 1, // Effect multipler
        slideShadows : true, // Enables slides shadows
      },
      grabCursor: true,
      parallax: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        1023: {
          slidesPerView: 1,
          spaceBetween: 0
        }
      },
      // Events
      on: {
        imagesReady: function(){
          this.el.classList.remove('loading');
        }
      }
    };
var mySwiper = new Swiper(sliderSelector, options);

// Initialize slider
mySwiper.init();
    
    
    </script>
</body>
</html>


<script type="text/javascript">
	$(document).ready(function(){
		$(".swiper-slide").click(function(){
		  var a = $(this>'.this_id').val();
		  alert(a);
		});
	});
</script>