<?php 
//convert datetime format to a nice looking date
function nice_date( $datetime ){
	$date = new DateTime( $datetime );
	return $date->format( 'l, F j' );
}

//no close php