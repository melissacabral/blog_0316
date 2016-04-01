<nav role='navigation'>
	<ul class="main">

	<?php //if an administrator is logged in, show the full nav bar, 
	//otherwise show the commenter nav items
	if( IS_ADMIN ){ 
		//ADMINISTRATOR! ?>
		
		<li class="dashboard"><a href="index.php">Dashboard</a></li>
		<li class="write"><a href="admin-write.php">Write Post</a></li>
		<li class="edit"><a href="admin-manage.php">Edit Posts</a></li>
		<li class="comments"><a href="#">Comments</a></li>
		<li class="users"><a href="admin-editprofile.php">Edit your Profile</a></li>

	<?php }else{ 
		//COMMENTER! ?>

		<li class="dashboard"><a href="index.php">Dashboard</a></li>
		<li class="users"><a href="admin-editprofile.php">Edit your Profile</a></li>

	<?php } ?>
	</ul>
</nav>