<?php 
require( 'db-config.php' ); 
include_once( 'functions.php' );
include('header.php'); /* contains the doctype through </header> */

//search configuration
$per_page = 1;
$current_page = 1; //what page to start on

//what phrase did the user search?
// URL looks like search.php?phrase=value
$phrase = mysqli_real_escape_string( $db, $_GET['phrase'] );
//get all the published posts whose title or body matches the phrase
$query = "SELECT post_id, title, body, date
			FROM posts
			WHERE is_published = 1
			AND ( title LIKE '%$phrase%' OR body LIKE '%$phrase%' ) ";
//run it
$result = $db->query($query);
//check it
if(!$result){
	echo $db->error;
}
//how many total posts were found?
$total = $result->num_rows;
?>
<main>
	<?php 
	if( $total >= 1 ){ 
		//how many total pages do we need. always round UP with ceil
		$total_pages = ceil($total/$per_page) ; 

		//what page is the user trying to view?
		//the URL will look like search.php?phrase=x&page=2
		if( $_GET['page'] ){
			$current_page = $_GET['page'];
		}
		//make sure they are viewing a valid page
		if( $current_page <= $total_pages ){
			//calculate the offset for the LIMIT
			$offset = ( $current_page - 1 ) * $per_page ;

			//modify the original query
			$query .= " LIMIT $offset, $per_page";

			//run it again
			$result = $db->query($query);
	?>
	<h2><?php echo $total; ?> Posts Found</h2>
	<h3>Viewing page <?php echo $current_page; ?> of <?php echo $total_pages; ?></h3>

	<?php while( $row = $result->fetch_assoc() ){ ?>
	<article>
		<h2>
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php echo $row['title']; ?>
			</a>
		</h2>
		<p><?php echo $row['body']; ?>...</p>
		<span class="post-meta"><?php echo nice_date($row['date']); ?></span>
	</article>
	<?php } //end while ?>

	<?php 
	$prev_page = $current_page - 1 ;
	$next_page = $current_page + 1 ;
	 ?>
	<section class="pagination">
		<?php if( $current_page > 1 ){ ?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev_page ?>" class="prev">
			Previous Page
		</a>
		<?php }else{ ?>
			<span class="unavailable">Previous Page</span>
		<?php } ?>


		<?php 
		//BONUS!  numbered pagination
		$counter = 1;
		while( $counter <= $total_pages ){
			if( $counter != $current_page ){ ?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $counter ?>">
				<?php echo $counter; ?>
			</a>
		<?php 
			}else{
				echo '<span>' . $counter . '</span>';  //the current page
			}
			$counter++;
		} //end while
		//end of numbered pagination
		?>



		<?php //check if there is a "next page"
		if( $next_page <= $total_pages ){ ?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next_page ?>" class="next">
				Next Page
			</a>
		<?php }else{ ?>
			<span class="unavailable">Next Page</span>
		<?php } ?>


		
	</section>

	<?php
		}//end if valid page
		else{
			echo 'Invalid Page';
		}
	//end if posts found 
	}else{
		echo 'No posts found, try another search';
	} ?>
</main>
<?php 
include('sidebar.php');
include('footer.php'); 
?>
