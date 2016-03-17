<?php 
//convert datetime format to a nice looking date
function nice_date( $datetime ){
	$date = new DateTime( $datetime );
	return $date->format( 'l, F j' );
}

//convert datetime format to RFC 822 format for the feed
function rss_date( $datetime ){
	$date = new DateTime( $datetime );
	return $date->format( 'r' );
}

//count the comments on ANY one post
//$post_id = INT - the post you are counting comments for
function count_comments( $post_id ){
	global $db;
	//count the approved comments on the post
	$query = "SELECT COUNT(*) AS total 
			FROM comments
			WHERE post_id = $post_id
			AND is_approved = 1";
	//run it!
	$result = $db->query($query);
	//check it
	if( $result->num_rows >= 1 ){
		//loop it
		while( $row = $result->fetch_assoc() ){
			echo '<span class="comment-count">' . $row['total'] . '</span>';
		} //end while loop
		
		//free it
		$result->free();
	} //end if	
}//end function

//no close php