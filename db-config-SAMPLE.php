<?php
//			Edit these values:
$database_name 	= 'my_db';
$db_user 		= 'my_user';
$db_pass 		= 'my_password';


//STOP EDITING

$db = new mysqli( 'localhost', $db_user, $db_pass, $database_name );

//if there was an error, kill the page
if( $db->connect_errno > 0 ){
	die('Could not connect to DB: ' . $db->connect_error );
}

//no close PHP!