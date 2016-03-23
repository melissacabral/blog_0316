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

//set encoding to utf8
$db->set_charset("utf8");

//error reporting: hide notices (comment this line out when debugging)
error_reporting( E_ALL & ~E_NOTICE ); 

//Define some URL/path constants so it makes linking to stuff easier
//URL is for href, src and other HTML stuff
//PATH is for includes and other PHP stuff
define( 'ROOT_URL', 'http://localhost/NAME_FOLDER/blog' );
define( 'ROOT_PATH', 'C:\xampp\htdocs\NAME_FOLDER\blog' );

//no close PHP!