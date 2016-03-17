<?php 
//connect to DB
require('db-config.php');
include_once('functions.php');
//this has to be echoed because the <? symbol confuses the PHP parser
echo '<?xml version="1.0"?>'; 

//get up to 10 recent published posts
$query = "SELECT posts.title, posts.post_id, posts.date, users.email, 
					users.username, posts.body
			FROM posts, users
			WHERE is_published = 1
			AND users.user_id = posts.user_id
			ORDER BY date DESC
			LIMIT 10";
//run it
$result = $db->query($query);
//check it
if(!$result){
	die( $db->error );
}
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Melissa's Blog Posts</title>
		<link>http://localhost/melissa-php-0316/blog</link>	
		<description>Just a blog about nothing in particular</description>
		<atom:link href="http://localhost/melissa-php-0316/blog/rss.php" rel="self" type="application/rss+xml" />
		<language>en-us</language>
		<pubDate><?php echo date('r'); ?></pubDate>
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<item>
			<title><?php echo $row['title'] ?></title>
			<link>http://localhost/melissa-php-0316/blog/single.php?post_id=<?php echo $row['post_id'] ?></link>
			<guid>http://localhost/melissa-php-0316/blog/single.php?post_id=<?php echo $row['post_id'] ?></guid>
			<pubDate><?php echo rss_date($row['date']) ?></pubDate>
			<author><?php echo $row['email'] ?> (<?php echo $row['username'] ?>)</author>
			<!-- The CDATA wrapper allows us to have HTML in the body of the post -->
			<description><![CDATA[ <?php echo $row['body'] ?> ]]></description>
		</item>
		<?php } ?>
	</channel>
</rss>