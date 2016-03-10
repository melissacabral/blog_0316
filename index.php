<?php 
require( 'db-config.php' ); 
include_once( 'functions.php' );
include('header.php'); /* contains the doctype through </header> */
?>
<main>
	<?php 
	//get the 2 most recent published posts
	$query = "SELECT title, body, date 
	FROM posts
	WHERE is_published = 1
	ORDER BY date DESC
	LIMIT 2";
		//run the query
	$result = $db->query($query);
		//check to see if posts were found
	if( $result->num_rows >= 1 ){		
		
		?>
		<h2>Recent Blog Posts</h2>
		<?php 
		//loop through the posts that it found
		while( $row = $result->fetch_assoc() ){ ?>
		<article>
			<h3><?php echo $row['title']; ?></h3>
			<div class="post-meta">
				Posted on <?php echo nice_date($row['date']); ?>
			</div>
			<p><?php echo $row['body']; ?></p>
		</article>

	<?php 
		} //end while loop
	} //end if posts found 
	else{
		echo 'No posts found';
	}//end if no posts found?>
</main>

<?php 
include('sidebar.php');
include('footer.php'); 
?>
	