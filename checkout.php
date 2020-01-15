<?php
session_start();
$subtotal=0;
//connect to database
$mysqli = mysqli_connect("localhost", "root", "", "bobbleshop");
//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title,si.cur_quant,si.id, si.item_price, st.sel_item_qty,st.sel_item_id FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql) or die(mysqli_error($mysqli));

$display_block = "<div  class = 'col-md-9' style = 'width:100%'><h1 class = 'h2' style = ' border-bottom:3px solid purple;padding-top:20px;margin-bottom:40px;padding-bottom:10px;'>Your order so far:</h1>";

$get_st_sql="SELECT * from store_shoppertrack";
$get_st_res = mysqli_query($mysqli, $get_st_sql) or die(mysqli_error($mysqli));
 while ($st_info = mysqli_fetch_array($get_st_res)) {
	 $st_id = $st_info['id'];
 }
if (mysqli_num_rows($get_cart_res) < 1) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"collections.php\">continue to shop</a>!</p>";
} else {
    //get info and build cart display
    $display_block .= <<<END_OF_TEXT
    <table class='table table-bordered'>
    <tr>
    <th>Title</th>
    
    <th>Price</th>
    <th>Qty</th>
    <th>Total Price</th>
    <th>Action</th>
    </tr>
END_OF_TEXT;

    while ($cart_info = mysqli_fetch_array($get_cart_res)) {
   	    $id = $cart_info['id'];
   	    $item_title = $cart_info['item_title'];
   	    $item_price = $cart_info['item_price'];
   	    $item_qty = $cart_info['sel_item_qty'];
		$new_qty = $cart_info['cur_quant']-$cart_info['sel_item_qty'];
   	   
	    $total_price = sprintf("%.02f", $item_price * $item_qty);
		$subtotal=sprintf("%.02f", $subtotal+$total_price);
		$sess_id = $_COOKIE['PHPSESSID'];
		if($cart_info['cur_quant'] >= $cart_info['sel_item_qty']){
		$update_quant = "UPDATE store_items SET cur_quant = '".$new_qty."'where'".$id."' = store_items.id AND cur_quant > '".$new_qty."'";
		$get_update_res = mysqli_query($mysqli, $update_quant) or die(mysqli_error($mysqli));
		
		}
		else{
			echo "Need to put ".$cart_info['item_title']." on back order";
		}
   	    $display_block .= <<<END_OF_TEXT
   	    <tr>
   	    <td>$item_title <br></td>
   	    
   	    <td>\$ $item_price <br></td>
   	    <td>$item_qty <br></td>
   	    <td>\$ $total_price</td>
   	    <td><a href="bhremovefromcart.php?id=$st_id">remove</a></td>
   	    </tr>
END_OF_TEXT;

    }

$_SESSION['sub'] = $subtotal;
    $display_block .= "<tr><td colspan=3>Subtotal</td><td>\$ $subtotal</td><td></td></tr></table>";
}
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>     Bobbleshop checkout   </title>
  
  <meta name="author" content="      sabah sabrina ashraf AND sabahsabrina@yahoo.com    ">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bobbleshop.css">

  
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
	<script src = "js/bobbleshop.js"></script>
<style>
	
		

		</style>
  
  </head>
  
<body  onLoad = "init();">

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
<canvas id="canvas" style = "padding-top:150px;margin-right:50px;" width="300" height="500">Alternative content</canvas>
</div>


		
		<?php echo $display_block; ?>
		<p>If there are no changes to be made, enter your details in the form below - especially credit card information</p>
        <form action="bhthankyou.php" class="form-group" method="post">
		<div  class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" name="name" id="name"><br>
             
	
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="adress"><br>
     			
    
				<label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city"><br>
                  
      
				<label for="state">State your state</label>
                <input type="text" class="form-control"name="state" id="state"><br>
       
				<label for="postcode">Postcode</label>
                <input type="text" class="form-control" name="postcode" id="postcode"><br>
				
				 <label for="tel">Telephone</label>
                <input type="text" class="form-control" name="tel" id="tel"><br>
					
				<label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email"><br>
           
				<label for="cardName">Name on card:</label>
                <input type="text" class="form-control" name="cardName" id="cardName"><br>
				<label for="expiry">Expiry date of card:</label>
	<?php
					$years = array();
					echo "<select class='form-control' style = 'width:7%;' name='month' id='sel'>";
					for ($i = 1; $i <= 12; $i++){
						echo "<option value='$i'>$i</option>";	
					}
					echo "</select>";
					$years = array();
					echo "<select class='form-control' style = 'width:10%; margin-top:5px;' name='year'>";
					for ($i = 2018; $i < 2021; $i++){
						echo "<option value='$i'>$i</option>";	
					}
					echo "</select><br>";
    ?>
			<input type="hidden" class="form-control" name="session" value="$_COOKIE['PHPSESSID']">
			<input type="hidden" class="form-control"name="total" value="<?php $subtotal; ?>">
           <!-- <input type="submit" class="form-control" name="submit">-->
			<button style  = "float:right" type="submit" class="btn btn-primary">Send</button>
    </div>
            
        </form>

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
	<li><a style = "font-size:18px" href="collections.html">Collections</a></li>
	<li><a style = "font-size:18px" href="forums.html">Forums</a></li>
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