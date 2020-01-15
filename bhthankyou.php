<?php
session_start();

//connect to database
$mysqli = mysqli_connect("localhost", "root", "", "bobbleshop");
$display_block = "<div  class = 'col-md-4' style = 'width:100%'><h1 class = 'h2' style = 'border-bottom:3px solid purple;margin-bottom:40px;padding-top:20px;padding-bottom:10px;'>thank you for shopping with us</h1>";
//check for cart items based on user session id
$get_cart_sql = "SELECT st.id,si.id, si.item_title, si.item_price, st.sel_item_qty FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));



//get all the form data and clean it

    $safe_sess = mysqli_real_escape_string($mysqli, $_POST['session']);
    $safe_name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $safe_address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
	$safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
	$safe_post = mysqli_real_escape_string($mysqli, $_POST['postcode']);
	$safe_tel = mysqli_real_escape_string($mysqli, $_POST['tel']);
	$safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$safe_cName = mysqli_real_escape_string($mysqli, $_POST['cardName']);
	$safe_month = mysqli_real_escape_string($mysqli, $_POST['month']);
	$safe_year = mysqli_real_escape_string($mysqli, $_POST['year']);
	//$safe_total = $total_price;
	$subtotal=$_SESSION['sub']; 

		
	
   $addtoOrder_sql = "INSERT INTO store_orders (order_date, order_name, order_address,order_city, order_state, order_zip, order_tel,order_email,item_total) VALUES (now(),'".$safe_name."', '".$safe_address."', '".$safe_city."', '".$safe_state."','".$safe_post."','".$safe_tel."','".$safe_email."','".$subtotal."')";
  	$addtocart_res = mysqli_query($mysqli, $addtoOrder_sql) or die(mysqli_error($mysqli));
		
$safe_id = mysqli_insert_id($mysqli);	
	
	
$display_block .= "<p>Your order has been placed successfully.</p>

<p>Please <a href=\"collections.php\">continue to shop</a>!</p>";

while ($cart_info = mysqli_fetch_array($get_cart_res)) {
   	    $id = $cart_info['id'];
   	    $item_title = $cart_info['item_title'];
   	    $item_price = $cart_info['item_price'];
   	    $item_qty = $cart_info['sel_item_qty'];
   	  
	    $total_price = sprintf("%.02f", $item_price * $item_qty);	  
	
//trying to insert into store_order_items

$addtoOrderItems_sql = "INSERT INTO store_orders_items (order_id, sel_item_id, sel_item_qty, sel_item_price) VALUES ('".$safe_id."', '".$id."', '".$item_qty."', '".$item_price."')";
  	$addtocart_res = mysqli_query($mysqli, $addtoOrderItems_sql) or die(mysqli_error($mysqli));
}	

$delOrderItems_sql= "delete from store_shoppertrack";
$del_res = mysqli_query($mysqli, $delOrderItems_sql) or die(mysqli_error($mysqli));
if (mysqli_num_rows($get_cart_res) < 1) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"collections.php\">continue to shop</a>!</p>";
}
//close connection to MySQL
mysqli_close($mysqli);
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>     Thank you  </title>
  
  <meta name="author" content="     sabah sabrina ashraf AND sabahsabrina@yahoo.com    ">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bobbleshop.css">

  
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
	<script src = "js/bobbleshop.js"></script>

  
  </head>
  
<body onLoad = "init();">





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
<main>
<div class = "container">

<div class = "row">
<div  class = "col-md-3">
<canvas id="canvas" style = "padding-top:140px;margin-right:80px;" width="300" height="500">Alternative content</canvas>
</div>





<?php echo $display_block; ?>
</div>

<div class = "col-lg-5">
<div id="accordion" style = "padding-top:140px;margin-left:80px;" >
  <div class="card " style="width:90%;height:80%;background-color:#fff;">
		<div class="card-header" >
			  <a class="card-link" data-toggle="collapse" href="#collapseOne">
			Coming Soon: Ant-Man and the Wasp!
			  </a>
		</div>
		<div id="collapseOne" class="collapse show" data-parent="#accordion">
		  <div class="card-body">
		  <p><small>Posted on January 26,2018</small></p>
		  <p>In an urgent mission to uncover secrets of the past Ant-Man
	 and the Wasp join forces in the upcoming Marvel film 
	Ant-Man and the Wasp!</p>
	<p>That’s not all, look for Ant-Man and the Wasp as 
	Funko Pop! Keychains and Pop!</p>

	<p>Coming this Summer!</p>
	<div class="d-flex flex-row ">
	<img style = "margin-right:20px" src ="images/wasp_news.jpg" width = "40%" alt = "wasp">
	<img src ="images/antiman_news.jpg" width = "40%" alt = "antiman">
	</div>
		  </div>
		</div>
  </div>

  <div class="card" style="width:90%;height:80%;background-color:#fff;">
    <div class="card-header">
      <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
      Pops are coming at Darling Harbour!
      </a>
    </div>
    <div id="collapseTwo" class="collapse" data-parent="#accordion">
      <div class="card-body">
	  <p><small>Posted on  February 12,2018</small></p>
      <p>Funko UK will be attending sydney this weekend from June 28th – 29th at the Darling harbour , Sydney!</p>
	  <img style = "margin-left:30px;margin-bottom:10px" src = "images/fancon_Funko2_large.jpg" alt= "fancon_Funko2_large" width= "60%">
	  <p>
The exclusive Pop!s, which were previously only available in North America, will be available at the darling Harbour! They can be found at stand E45 and will be available first-come, first-served, along with an assortment of regular release Funko products!</p>
      </div>
    </div>
  </div>

  <div class="card"style="width:90%;height:80%;background-color:#fff;">
    <div class="card-header">
      <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
       Star Wars Celebration 2018 Exclusives !
      </a>
    </div>
    <div id="collapseThree" class="collapse" data-parent="#accordion">
      <div class="card-body">
	  <p><small>Posted on  March 29, 2018</small></p>
      <p>First of all, if you are attending the show, please make sure you enter the online lottery for a chance to win a ticket to access our booth! </p>

<p>Here is the first wave of our exclusives for Star Wars Celebration 2018!</p>
<div class="d-flex flex-row ">
<img style = "margin-right:30px" src ="images/pop_starwars_princessLeia.jpg" width = "45%" height = "55%" alt = "pop_starwars_princessLeia">
<img src ="images/pop_starwars_c3po.jpg" width = "45%" height = "55%"  alt = "pop_starwars_c3po">
</div>
      </div>
    </div>
  </div>

</div>

</div>
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