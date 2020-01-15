<?php
include 'ch21_include.php';
//doDB();
$myclass = new Myclass;




//check to see if we're showing the form or adding the post
if (!$_POST) {
   // showing the form; check for required item in query string
   if (!isset($_GET['post_id'])) {
      header("Location: showtopic.php");
      exit;
   }

   //create safe values for use
   $safe_post_id = mysqli_real_escape_string($myclass -> mysqli	, $_GET['post_id']);

   //still have to verify topic and post
   $verify_sql = "SELECT ft.topic_id, ft.topic_title, ft.forum_id  FROM forum_posts
                  AS fp LEFT JOIN forum_topics AS ft ON fp.topic_id =
                  ft.topic_id WHERE fp.post_id = '".$safe_post_id."'";

   $verify_res = mysqli_query($myclass -> mysqli, $verify_sql)
                 or die(mysqli_error($myclass -> mysqli	));

   if (mysqli_num_rows($verify_res) < 1) {
      //this post or topic does not exist
      header("Location: catlist.php");
      exit;
   } else {
      //get the topic id and title
      while($topic_info = mysqli_fetch_array($verify_res)) {
         $topic_id = $topic_info['topic_id'];
		  $forum_id = $topic_info['forum_id'];
		 
         $topic_title = stripslashes($topic_info['topic_title']);
      }
?>
    <!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title> replyToPost  </title>
  
  <meta name="author" content="     Sabah Sabrina Ashraf    ">

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
<li class="nav-item"><a class="nav-link" href="index.html" >Home</a></li>
<li class="nav-item"><a class="nav-link" href="about-us.html" >About us</a></li>
<li class="nav-item"><a class="nav-link" href="custom-made.php">Custom Made</a></li>
<li class="nav-item"><a class="nav-link" href="collections.php">Collections</a></li>
<li class="nav-item"><a class="nav-link" href="forums.php"id="current-page">Forums</a></li>
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
 <div  class = 'col-md-9' style = 'width:100%;padding-left:50px;'>     
	  <h1 class = "h2" style = " border-bottom:3px solid purple;padding-top:20px;margin-bottom:40px;padding-bottom:10px;">Post Your Reply in <?php echo $topic_title; ?></h1>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	   <div  class="form-group">
      <p><label for="post_owner">Your Email Address:</label><br/>
      <input class="form-control" type="email" id="post_owner" name="post_owner" size="40"
         maxlength="150" required="required"></p>
      <p><label for="post_text">Post Text:</label><br/>
      <textarea class="form-control" id="post_text" name="post_text" rows="8" cols="40"
         required="required"></textarea></p>
      <input class="form-control" type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
	  <input class="form-control"type="hidden" name="forum_id" value="<?php echo $forum_id; ?>">
      <button  class="btn btn-primary" type="submit" name="submit" value="submit" style = "float:right">Add Post</button>
	  </div>
      </form>
      
<?php
      //free result
      mysqli_free_result($verify_res);

      //close connection to MySQL
      mysqli_close($myclass -> mysqli	);
   }

} else if ($_POST) {
      //check for required items from form
      if ((!$_POST['topic_id']) || (!$_POST['post_text']) ||
          (!$_POST['post_owner'])||(!$_POST['forum_id'])) {
          header("Location: catlist.php");
          exit;
      }

      //create safe values for use
	  $safe_forum_id = mysqli_real_escape_string($myclass -> mysqli	, $_POST['forum_id']);
      $safe_topic_id = mysqli_real_escape_string($myclass -> mysqli	, $_POST['topic_id']);
      $safe_post_text = mysqli_real_escape_string($myclass -> mysqli	, $_POST['post_text']);
      $safe_post_owner = mysqli_real_escape_string($myclass -> mysqli	, $_POST['post_owner']);

      //add the post
      $add_post_sql = "INSERT INTO forum_posts (topic_id,post_text,
                       post_create_time,post_owner,forum_id) VALUES
                       ('".$safe_topic_id."', '".$safe_post_text."',
                       now(),'".$safe_post_owner."','".$safe_forum_id."' )";
      $add_post_res = mysqli_query($myclass -> mysqli	, $add_post_sql)
                      or die(mysqli_error($myclass -> mysqli	));

      //close connection to MySQL
      mysqli_close($myclass -> mysqli	);

      //redirect user to topic
      header("Location: showtopic.php?topic_id=".$_POST['topic_id']);
      exit;
}
?>
<p style = "margin-top:30px">Would you like to <a href = "showtopic.php">See topiclist</a>?</p>
<p>Would you like to <a href = "addtopic.php">add a topic</a>?</p>

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
