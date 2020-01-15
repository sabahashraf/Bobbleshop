<!Doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>     Contact   </title>
  
  <meta name="author" content="      Sabah Sabrina Ashraf AND sabahsabrina@yahoo.com   ">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bobbleshop.css">

  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
	<script src = "js/bobbleshop.js"></script>
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
<li class="nav-item"><a class="nav-link" href="index.html"  >Home</a></li>
<li class="nav-item"><a class="nav-link" href="about-us.html" >About us</a></li>
<li class="nav-item"><a class="nav-link" href="custom-made.php">Custom Made</a></li>
<li class="nav-item"><a class="nav-link" href="collections.php">Collections</a></li>
<li class="nav-item"><a class="nav-link" href="forums.php">Forums</a></li>
<li class="nav-item"><a class="nav-link" href="contact-us.php"id="current-page">Contact Us</a></li>
</ul>
  </div>  
</nav>
<main >
<div class = "container">
<div class = "row">
<div  class = "col-md-3">
<canvas id="canvas" style = "padding-top:150px;margin-right:50px;" width="300" height="500">Alternative content</canvas>
</div>
<div  class = "col-md-9" style = "width:100%;padding-left:50px;">
<h1 class = "h2" style = " border-bottom:3px solid purple;padding-top:20px;margin-bottom:40px;padding-bottom:10px;">Contact Us</h1>


<p>If you have any question or you want to sell excess bobbleheads use the form below or give us a call at 0405211111</p>
<form  method = "post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <div  class="form-group">
   <?php
   //  variable set to true, if becomes false generates an error message:
$okay = TRUE;
if(isset($_POST['submit'])){
// Validate the name:
if (empty($_POST['usr'])) {
	echo "<input type = 'text' class='form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Please enter your name.'><br>";
	$okay = FALSE;
}
// Validate the email:
else if (empty($_POST['email'])) {
	echo "<input type = 'text' class='form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Please enter your email address.'><br>";
	$okay = FALSE;
}
// Validate phone number:
else if (empty($_POST['ph'])) {
	echo "<input type = 'text' class='form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Please enter your phone number.'><br>";
	$okay = FALSE;
}
else if (!is_numeric($_POST['ph'])){
	echo "<input type = 'text' class='form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Please enter a valid phone number.'><br>";
	$okay = FALSE;
}

// Validate the comment:
else if (empty($_POST['comment'])) {
	echo "<input type = 'text' class='form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Please write something.'><br>";
	$okay = FALSE;
}

	else if ($okay) { 
	echo "<input type = 'text' class='alert form-control' style = 'color:purple;font-weight:bold;background-color:#c91678' value = 'Thanks for contacting us.We will get back to you as soon as possible.'><br>";
	 }
}
?>		<p>Suggestions: <span id="txtHint"></span></p>
     	 <input type="text" class="form-control" placeholder = "Name" name="usr" onkeyup="showHint(this.value)" ><br>
	  <input type="email" class="form-control" placeholder = "Email" name ="email"><br>
	   <input type="text" class="form-control" placeholder = "Phone Number" name ="ph"><br>
	    <textarea class="form-control" rows="5" placeholder = "Message" name="comment"></textarea><br>
		<button style  = "float:right" type="submit" name ="submit" class="btn btn-primary">Send</button>
    </div>

      
      
    
  </form>


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