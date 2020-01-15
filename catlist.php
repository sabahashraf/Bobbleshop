<?php
include 'ch21_include.php';
//doDB();
$myclass = new Myclass;
if(!isset($_POST['category'])){

	header("Location: forums.php");
	exit;
}
//create safe values for use
$safe_forum_id = mysqli_real_escape_string($myclass -> mysqli	,$_POST['category']);
 
 //
 $get_forums_sql = "SELECT ft.topic_id, ft.topic_title, DATE_FORMAT(topic_create_time,  '%b %e %Y at %r') as fmt_topic_create_time,ft.forum_id, ft.topic_owner FROM forum_topics AS ft LEFT JOIN forums ON forums.forum_id = ft.forum_id WHERE ft.forum_id = '".$safe_forum_id."'";
 
 $get_forums_res = mysqli_query($myclass -> mysqli	, $get_forums_sql) or die(mysqli_error($myclass -> mysqli	));
 
 $get_forum_name = "SELECT forum_name FROM forums WHERE forum_id = '".$safe_forum_id."'";
 
 $get_forum_name_res = mysqli_query($myclass -> mysqli	,$get_forum_name ) or die(mysqli_error($myclass -> mysqli	));
 if (mysqli_num_rows($get_forums_res) < 1) {
	//there are no topics, so say so
	$display_block = "<p><em>No topics exist.</em></p>";
} else {
		
		 
	//create the display string
    $display_block = <<<END_OF_TEXT
    <table  class='table table-bordered'>
    <tr>
    <th>TOPIC TITLE</th>
    <th># of POSTS</th>
    </tr>
END_OF_TEXT;
while ($topic_info = mysqli_fetch_array($get_forums_res)) {
		$topic_id = $topic_info['topic_id'];
		$topic_title = stripslashes($topic_info['topic_title']);
		$topic_create_time = $topic_info['fmt_topic_create_time'];
		$topic_owner = stripslashes($topic_info['topic_owner']);
		//get number of posts
		$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM forum_posts WHERE topic_id = '".$topic_id."'";
		$get_num_posts_res = mysqli_query($myclass -> mysqli	, $get_num_posts_sql) or die(mysqli_error($myclass -> mysqli	));

		while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
			$num_posts = $posts_info['post_count'];
		}
		while ($forum_info = mysqli_fetch_array( $get_forum_name_res)) {
			$forum_name = $forum_info['forum_name'];
		}
		
				//add to display
		$display_block .= <<<END_OF_TEXT
		<tr>
		<td><a href="showtopic.php?topic_id=$topic_id && forum_id =$safe_forum_id"><strong>$topic_title</strong></a><br/>
		Created on $topic_create_time by $topic_owner</td>
		<td class="num_posts_col">$num_posts</td>


		</tr>
END_OF_TEXT;
	}
	//free results
	mysqli_free_result( $get_forums_res);
	mysqli_free_result($get_forum_name_res);
	mysqli_free_result($get_num_posts_res);
	

	//close connection to MySQL
	mysqli_close($myclass -> mysqli	);

	//close up the table
	$display_block .= "</table>";
}
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>   </title>
  
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

<div  class = 'col-md-9' style = 'width:100%;padding-left:50px;'><h1 class = 'h2' style = 'border-bottom:3px solid purple;margin-bottom:40px;padding-top:20px;padding-bottom:10px;'>Topics in this category - <?php echo $forum_name;?></h1>
<?php echo $display_block; ?>
<p  style = "margin-top:30px">Would you like to <a href="addtopic.php">add a topic</a>?</p>
<p>Would you like to <a href="forums.php">go back to Category list</a>?</p>

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