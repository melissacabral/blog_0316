<?php 
session_start(); 
require('../db-config.php');

//if the user is returning with a valid cookie, re-create the session
if( array_key_exists( 'secretkey', $_COOKIE ) 
	AND array_key_exists( 'user_id', $_COOKIE ) ){

	$_SESSION['secretkey'] = $_COOKIE['secretkey'];
	$_SESSION['user_id'] = $_COOKIE['user_id'];
}

//PASSWORD PROTECTION!
//Make sure the secret key matches the one in the DB
$user_id = $_SESSION['user_id'];
$secretkey = $_SESSION['secretkey'];
$query = "SELECT * FROM users
		WHERE user_id = $user_id
		AND secret_key = '$secretkey'
		LIMIT 1";
$result = $db->query($query);
//if the query has an error because of a NULL user_id, send them back to login
if(!$result){
	header('Location:../login.php');
}
//if no rows are found because they are not logged in, send them to login
if($result->num_rows == 1){
	//extract the info about the user
	$row = $result->fetch_assoc();
	$username = $row['username'];
}else{
	header('Location:../login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="styles/normalize.css">
	<link rel="stylesheet" type="text/css" href="styles/admin-style.css">
	<link rel="stylesheet" type="text/css" 
	href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic">
	<link rel="stylesheet" type="text/css" 
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<header role="banner">
  <h1>Admin Panel</h1>
  <ul class="utilities">
    <li class="users"><a href="#">My Account</a></li>
    <li class="logout warn"><a href="../login.php?action=logout">Log Out</a></li>
  </ul>
</header>

<nav role='navigation'>
  <ul class="main">
    <li class="dashboard"><a href="#">Dashboard</a></li>
    <li class="write"><a href="#">Write Post</a></li>
    <li class="edit"><a href="#">Edit Posts</a></li>
    <li class="comments"><a href="#">Comments</a></li>
    <li class="users"><a href="#">Manage Users</a></li>
  </ul>
</nav>

<main role="main">
  <section class="panel important">
    <h2>Welcome to Your Dashboard </h2>
    <ul>
      <li>Important panel that will always be really wide Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
      <li>Aliquam tincidunt mauris eu risus.</li>
      <li>Vestibulum auctor dapibus neque.</li>
    </ul>
  </section>
  <section class="panel">
    <h2>Posts</h2>
    <ul>
      <li><b>2458 </b>Published Posts</li>
      <li><b>18</b> Drafts.</li>
      <li>Most popular post: <b>This is a post title</b>.</li>
    </ul>
  </section>
  <section class="panel">
    <h2>Chart</h2>
    <ul>
      <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
      <li>Aliquam tincidunt mauris eu risus.</li>
      <li>Vestibulum auctor dapibus neque.</li>
    </ul>
  </section>
  <section class="panel important">
    <h2>Write a post</h2>
    <form action="#">
      <div class="twothirds">
        <label for="name">Text Input:</label>
        <input type="text" name="name" id="name" placeholder="John Smith" />

        <label for="textarea">Textarea:</label>
        <textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>

      </div>
      <div class="onethird">
        <legend>Radio Button Choice</legend>

        <label for="radio-choice-1">
          <input type="radio" name="radio-choice" id="radio-choice-1" value="choice-1" /> Choice 1
        </label>

        <label for="radio-choice-2">
          <input type="radio" name="radio-choice" id="radio-choice-2" value="choice-2" /> Choice 2
        </label>


        <label for="select-choice">Select Dropdown Choice:</label>
        <select name="select-choice" id="select-choice">
          <option value="Choice 1">Choice 1</option>
          <option value="Choice 2">Choice 2</option>
          <option value="Choice 3">Choice 3</option>
        </select>


        <div>
          <label for="checkbox">
            <input type="checkbox" name="checkbox" id="checkbox" /> Checkbox
          </label>
        </div>

        <div>
          <input type="submit" value="Submit" />
        </div>
      </div>
    </form>
  </section>
  <section class="panel">
    <h2>feedback</h2>
    <div class="feedback">This is neutral feedback Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, praesentium. Libero perspiciatis quis aliquid iste quam dignissimos, accusamus temporibus ullam voluptatum, tempora pariatur, similique molestias blanditiis at sunt earum neque.</div>
    <div class="feedback error">This is warning feedback
<ul>
  <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
  <li>Aliquam tincidunt mauris eu risus.</li>
  <li>Vestibulum auctor dapibus neque.</li>
</ul>  </div>
    <div class="feedback success">This is positive feedback</div>

  </section>
  <section class="panel ">
    <h2>Table</h2>
    <table>
      <tr>
        <th>Username</th>
        <th>Posts</th>
        <th>comments</th>
        <th>date</th>
      </tr>
      <tr>
        <td>Pete</td>
        <td>4</td>
        <td>7</td>
        <td>Oct 10, 2015</td>

      </tr>
      <tr>
        <td>Mary</td>
        <td>5769</td>
        <td>2517</td>
        <td>Jan 1, 2014</td>
      </tr>
    </table>
  </section>

</main>
<footer role="contentinfo">Easy Admin Style by Melissa Cabral</footer>

</body>
</html>