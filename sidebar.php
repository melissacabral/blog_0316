<aside>
	<?php //get the titles of up to 5 latest published posts
	$query_latest = "SELECT title 
					FROM posts 
					WHERE is_published = 1
					ORDER BY date DESC
					LIMIT 5"; 
	//run it
	$result_latest = $db->query($query_latest);
	//check to see if rows were found
	if( $result_latest->num_rows >= 1 ){
	?>
	<section>
		<h2>Latest Posts</h2>
		<ul>
			<?php 
			//loop it once per post
			while( $row_latest = $result_latest->fetch_assoc() ){ ?>
			<li><a href="#"><?php echo $row_latest['title'] ?></a></li>
			<?php 
			} //end while 
			//free the result
			$result_latest->free(); ?>
		</ul>
	</section>
	<?php 
	} //end if ?>

	<?php //get all category names in alphabetical order 
	$query_cats = "SELECT *
					FROM categories
					ORDER BY name ASC"; 
	//run it
	$result_cats = $db->query($query_cats);
	//check to see if rows were found
	if( $result_cats->num_rows >= 1 ){
	?>
	<section>
		<h2>Categories</h2>
		<ul>
			<?php 
			//loop it once per post
			while( $row_cats = $result_cats->fetch_assoc() ){ ?>
			<li><a href="#"><?php echo $row_cats['name'] ?></a></li>
			<?php 
			} //end while 
			//free the result
			$result_cats->free(); ?>
		</ul>
	</section>
	<?php 
	} //end if ?>

	<?php //get all link titles in random order and make them go to the URL  
	$query_links = "SELECT title, url 
					FROM links 				
					ORDER BY RAND()"; 
	//run it
	$result_links = $db->query($query_links);
	//check to see if rows were found
	if( $result_links->num_rows >= 1 ){
	?>
	<section>
		<h2>Latest Posts</h2>
		<ul>
			<?php 
			//loop it once per post
			while( $row_links = $result_links->fetch_assoc() ){ ?>
			<li>
			<a href="<?php echo $row_links['url']; ?>">
			<?php echo $row_links['title'] ?>
			</a>
			</li>
			<?php 
			} //end while 
			//free the result
			$result_links->free(); ?>
		</ul>
	</section>
	<?php 
	} //end if ?>
</aside>