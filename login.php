<?php 
session_start();
require('db-config.php');
include_once('functions.php');

//Logout action
if($_GET['action'] == 'logout'){
	//TODO: remove the secret key from the DB
	
	//destroy the session, make all cookies null and expired
	session_destroy();

	unset( $_SESSION['secretkey'] );
	setcookie( 'secretkey', '', time() - 999999 );

	unset( $_SESSION['user_id'] );
	setcookie( 'user_id', '', time() - 999999 );

	$message = 'You are now logged out';
	$status = 'information';
}

//begin form parser
if( $_POST['did_login'] ){
	//extract and sanitize
	$username = mysqli_real_escape_string($db, strip_tags($_POST['username']));
	$password = mysqli_real_escape_string($db, strip_tags($_POST['password']));
	
	//validate
	$valid = true;
	//username must be between 5 - 50 chars
	if( strlen($username) < 5 AND strlen($username) > 50 ){
		$valid = false;
	}
	//password must be at least 8 chars
	if( strlen($password) < 8 ){
		$valid = false;
	}
	//if valid, look them up in the db, then log them in
	//sha1 is a hash algorithm
	if( $valid ){
		$query = "SELECT user_id, is_admin
		FROM users
		WHERE username = '$username'
		AND password = sha1('$password')
		LIMIT 1";
		$result = $db->query($query);
		if(!$result){
			echo $db->error;
		}
		//if one row is found, SUCCESS! log them in for 1 week
		if( $result->num_rows == 1 ){
			//success
			$secretkey = sha1(microtime() . 'sgf9htd.knhs3gre!lhijhrskj85tdg hkj');
			setcookie( 'secretkey', $secretkey, time() + 60 * 60 * 24 * 7 );
			$_SESSION['secretkey'] = $secretkey;

			//get the user id out of the result
			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];
			//store the user_id on their computer
			setcookie('user_id', $user_id, time() + 60 * 60 * 24 * 7 );
			$_SESSION['user_id'] = $user_id;

			//store the key in the DB
			$query = "UPDATE users
			SET secret_key = '$secretkey'
			WHERE user_id = $user_id
			LIMIT 1";
			$result = $db->query($query);
			if(!$result){
				die($db->error);
			}else{
				//redirect to admin panel
				header('Location:admin/');
			}
		}else{
			//error
			$message = 'Your login info is incorrect, try again.';
			$status = 'error';
		}	
	}else{
		//invlaid
		$message = 'Your login info is invalid, try again.';
		$status = 'error';
	}//end if valid
	
}//end form parser
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log In to your account</title>
	<link rel="stylesheet" type="text/css" href="styles/normalize.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="admin/styles/admin-style.css">
</head>
<body class="login">
	
	<h1>Log In</h1>
	
	<?php 
	if(isset($message)){
		echo '<div class="'. $status .' feedback">';
		echo $message;
		echo '</div>';
	} ?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label>Username:</label>
		<input type="text" name="username">

		<label>Password:</label>
		<input type="password" name="password">

		<input type="submit" value="Log In">
		<input type="hidden" name="did_login" value="1">
	</form>

</body>
</html>