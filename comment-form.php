<section id="comment-form">	
	<?php 
	//parser feedback
	if(isset($message)){
		echo '<div class="message">' . $message . '</div>';
	}
	?>	
	<form action="#comment-form" method="post">
		<h2><label for="body">Leave a Comment:</label></h2>
		<textarea name="body" id="body"></textarea>

		<input type="submit" value="Save Comment">
		<input type="hidden" name="did_comment" value="1">
	</form>
</section>