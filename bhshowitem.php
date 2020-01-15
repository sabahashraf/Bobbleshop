<?php
session_start();

//connect to database
$mysqli = mysqli_connect("localhost", "root", "", "bobbleshop");

$display_block = "<h1 class = 'h2' style = ' border-bottom:3px solid purple;padding-top:20px;margin-bottom:40px;padding-bottom:10px;'>Bobbleshop - Item Detail</h1>";

//create safe values for use
$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image, si.cur_quant FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$safe_item_id."'";
$get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_item_res) < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
} else {
   //valid item, get info
   while ($item_info = mysqli_fetch_array($get_item_res)) {
	   $cat_id = $item_info['cat_id'];
	   $cat_title = strtoupper(stripslashes($item_info['cat_title']));
	   $item_title = stripslashes($item_info['item_title']);
	   $item_price = $item_info['item_price'];
	   $item_desc = stripslashes($item_info['item_desc']);
	   $item_image = $item_info['item_image'];
	}

   //make breadcrumb trail & display of item
   $display_block .= <<<END_OF_TEXT
   <p style="margin-top: 30px;"><em>You are viewing:</em><br/>
   <strong><a href="collections.php?cat_id=$cat_id">$cat_title</a> &gt; $item_title</strong></p>
   <div style="float: left;"><img src="images/$item_image" width = "300" alt="$item_title" /></div>
   <div style="float: left; padding-left: 20px">
   <p><strong>Description:</strong><br/>$item_desc</p>
   <p><strong>Price:</strong> \$$item_price</p>
   <form method="post" action="bhaddtocart.php">
END_OF_TEXT;

    //free result
    mysqli_free_result($get_item_res);

   

  
	$new_quant=null;
  
	$get_quant= "SELECT cur_quant from store_items where id =".$safe_item_id;
	$get_quant_res = mysqli_query($mysqli, $get_quant)
                     or die(mysqli_error($mysqli));
		while($item_info= mysqli_fetch_array($get_quant_res)){			 
		if($item_info['cur_quant']== 0){
				echo "<p>Sorry, this item currently unavailable.</p>";
			}
			
			else{
				
				$new_quant = $item_info['cur_quant'];
				
		
    $display_block .= "
    <p><label for=\"sel_item_qty\">Select Quantity:</label>
    <select id=\"sel_item_qty\" name=\"sel_item_qty\">";

    for($i=1; $i<=$new_quant; $i++) {
        $display_block .= "<option value=\"".$i."\">".$i."</option>";
    }
	}
}
    $display_block .= <<<END_OF_TEXT
    </select></p>
    <input type="hidden" name="sel_item_id" value="$_GET[item_id]" />
    <button type="submit" name="submit" value="submit" class="btn btn-primary">Add to Cart</button>
    </form>
    </div>
END_OF_TEXT;

}

//close connection to MySQL
mysqli_close($mysqli);
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>     Bobbleshop showitem   </title>
  
  <meta name="author" content="      sabah sabrina ashraf AND sabahsabrina@yahoo.com     ">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bobbleshop.css">

  
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
	<script src = "js/bobbleshop.js"></script>

  
  </head>
  
<body>
<header>
		<div class="d-flex justify-content-start" style = "background-color:white">
			<img src = "images/bobble logo.png" id = "logo" width = "375px" height = "100px" alt = "logo">
		</div>
</header>

<nav class="navbar  navbar-expand-md "style = "background-color:#c91678;">
 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"><img src="images/menu_icon.png" width="25" height="25" alt="Responsive Menu icon"/></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
 

<ul  class="navbar-nav">
<li class="nav-item"><a class="nav-link" href="index.html" >Home</a></li>
<li class="nav-item"><a class="nav-link" href="about-us.html" >About us</a></li>
<li class="nav-item"><a class="nav-link" href="custom-made.php">Custom Made</a></li>
<li class="nav-item"><a class="nav-link" href="collections.php"id="current-page">Collections</a></li>
<li class="nav-item"><a class="nav-link" href="forums.php">Forums</a></li>
<li class="nav-item"><a class="nav-link" href="contact-us.php">Contact Us</a></li>
</ul>
  </div>  
</nav>
<main style ="padding-bottom:370px">
<div class = "container">





<?php echo $display_block; ?>

</div>

</main>
<footer id = "main-footer">
<div class="row" style = "padding:30px">
  <div class="col-md-3 col-sm-6">
  <h4  style = "color:#000">QUICK LINKS</h4>
<ul >
  <li><a  style = "font-size:18px" href="about-us.html" >About us</a></li>
	<li><a style = "font-size:18px" href="custom-made.php">Custom Made</a></li>
	<li><a style = "font-size:18px" href="collections.php">Collections</a></li>
	<li><a style = "font-size:18px" href="forums.php">Forums</a></li>
	<li><a style = "font-size:18px" href="contact-us.php">Contact Us</a></li>
</ul>
  </div>
  <div class="col-md-3 col-sm-6">
   <h4 style = "color:#000">GET CONNECTED</h4>
  <ul class = "list-inline">
  <li class="list-inline-item"><a href="https://www.facebook.com"><i class="fab fa-facebook-square fa-2x" ></i></a></li>
   <li class="list-inline-item"><a href="https://www.instagram.com"><i class="fab fa-instagram fa-2x"></i></a></li>
    <li class="list-inline-item"><a href="https://www.pinterest.com"><i class="fab fa-pinterest-square fa-2x"></i></a></li>
	 <li class="list-inline-item"><a href="https://www.facebook.com"><i class="fab fa-twitter-square fa-2x"></i></a></li>
	 </ul>
	 </div>
  <div class="col-md-3 col-sm-6">
   <h4 style = "color:#000">CONTACT US</h4>
 <ul>
 <li style = "color:#000">Email:<a style = "font-size:18px" href= "mailto:info@bobbleshop.com" target = "_top" >info@bobbleshop.com</a></li>
 <li style = "color:#000">Phone: 040-5219367</li>
 </ul>
 </div>
  <div class="col-md-3 col-sm-6">
  <h4 style = "color:#000">NEWSLETTER</h4>
  <p style = "color:#000" >Sign up for promotions</p>
  <form>
      <label class="sr-only" for="email">Email</label>
            <input type="email" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="your-email@example.com">
            <button class="btn btn-primary" style = "margin-top:20px; margin-left:0px;" type="submit">Subscribe</button>
          </form></div>
</div>
<ul class = "list-inline">
<li class = "text-left p-4  list-inline-item" style = "font-size:15px">Copyright 2018 &copy; bobbleshop</li>
<li  class="list-inline-item "><a style = "font-size:15px" href = "privacy.html">Privacy policy</a><li>
</ul>
</footer>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</body>
</html>