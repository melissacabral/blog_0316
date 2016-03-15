<?php
/*
Template for displaying any single post, with comments
link to this file like this:
single.php?post_id=X
*/ 
$post_id = $_GET['post_id'];
require( 'db-config.php' ); 
include_once( 'functions.php' );
include('comment-parse.php');
include('header.php'); /* contains the doctype through </header> */
?>
<main>
	<?php 
	//get the 1 published post that we are trying to view
	$query = "SELECT posts.post_id, posts.title, posts.body, posts.date, categories.name, users.username, posts.allow_comments
			FROM posts, categories, users
			WHERE posts.is_published = 1
			AND posts.category_id = categories.category_id
			AND users.user_id = posts.user_id
			AND posts.post_id = $post_id
			ORDER BY posts.date DESC
			LIMIT 1";
		//run the query
	$result = $db->query($query);

	//if the result is bad, show us the db error message
	if(!$result){
		echo $db->error;
	}

	//check to see if posts were found
	if( $result->num_rows >= 1 ){		
		
		?>
		<h2>Blog Post</h2>
		<?php 
		//loop through the posts that it found
		while( $row = $result->fetch_assoc() ){
			//check if comments are allowed so we can use this 
			//variable at the bottom of the page
			$comments_allowed = $row['allow_comments'];
		 ?>
		<article>
			<h3><?php echo $row['title']; ?></h3>
			<div class="post-meta">				
				Posted <?php echo nice_date($row['date']); ?> 
				by <?php echo $row['username'] ?> |  
				Category: <?php echo $row['name']; ?>
			</div>
			<p><?php echo $row['body']; ?></p>
		</article>

	<?php 
		} //end while loop
		$result->free();

		//get all the approved comments written about this post
		$query = "SELECT users.username, comments.date, comments.body
				FROM users, comments
				WHERE comments.post_id = $post_id
				AND comments.is_approved = 1
				AND users.user_id = comments.user_id
				ORDER BY date ASC";
		//run it
		$result = $db->query($query);
		//check it
		if(!$result){
			echo $db->error;
		}
		if( $result->num_rows >= 1 ){
	?>	

	<h2><?php count_comments($post_id); ?> Comments:</h2>

	<ul class="comment-list">
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<li>
			<h3>
				Comment from <?php echo $row['username']; ?> 
				on <?php echo nice_date($row['date']); ?>
			</h3>
			<p><?php echo $row['body']; ?></p>
		</li>
		<?php } //end while comments 
		$result->free();
		?>
	</ul>

	<?php
		} //end if comments found
		else{
			echo '<h2>This post has no comments yet.</h2>';
		}

		//If comments are allowed on this post, show the form
		if( $comments_allowed ){
			include('comment-form.php');
		}else{
			echo 'Comments are closed.';
		} //end if comments allowed

	} //end if post found 
	else{
		echo 'No posts found';
	}//end if no posts found?>
</main>

<?php 
include('sidebar.php');
include('footer.php'); 
?>
	