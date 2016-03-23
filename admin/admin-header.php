<?php 
session_start(); 

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
	//SUCCESSFULLY AUTHENTICATED USER!
	//extract the info about the user
	$row = $result->fetch_assoc();

	//define constants for any useful info about the logged in user
	define( 'USER_ID', $user_id );
	define( 'USERNAME', $row['username'] );
	define( 'IS_ADMIN', $row['is_admin'] );
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
      <li class="users"><a href="#">Logged in as: <?php echo USERNAME; ?></a></li>
      <li class="logout warn"><a href="../login.php?action=logout">Log Out</a></li>
    </ul>
  </header>