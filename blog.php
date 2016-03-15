<?php 
require( 'db-config.php' ); 
include_once( 'functions.php' );
include('header.php'); /* contains the doctype through </header> */
?>
<main>
	<?php 
	//get the 2 most recent published posts
	$query = "SELECT posts.post_id, posts.title, posts.body, posts.date, categories.name, users.username
			FROM posts, categories, users
			WHERE posts.is_published = 1
			AND posts.category_id = categories.category_id
			AND users.user_id = posts.user_id
			ORDER BY posts.date DESC";
		//run the query
	$result = $db->query($query);

	//if the result is bad, show us the db error message
	if(!$result){
		echo $db->error;
	}

	//check to see if posts were found
	if( $result->num_rows >= 1 ){		
		
		?>
		<h2>My Blog</h2>
		<?php 
		//loop through the posts that it found
		while( $row = $result->fetch_assoc() ){ ?>
		<article>
			<h3><a href="single.php?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></h3>
			<div class="post-meta">				
				Posted <?php echo nice_date($row['date']); ?> 
				by <?php echo $row['username'] ?> |  
				Category: <?php echo $row['name']; ?>
				<?php count_comments($row['post_id']); ?>
			</div>
			<p><?php echo $row['body']; ?></p>
		</article>

	<?php 
		} //end while loop
		$result->free();
	} //end if posts found 
	else{
		echo 'No posts found';
	}//end if no posts found?>
</main>

<?php 
include('sidebar.php');
include('footer.php'); 
?>
	