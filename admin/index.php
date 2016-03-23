<?php 
require( '../db-config.php' );
include_once( ROOT_PATH . '/functions.php' );
require( ROOT_PATH . '/admin/admin-header.php' ); 
include( ROOT_PATH . '/admin/admin-nav.php' ); ?>  

<main role="main">
    <section class="panel important">
        <h2>Welcome to Your Dashboard, <?php echo USERNAME; ?></h2>
        <ul>
            <li>Account type: <?php echo IS_ADMIN == 1 ? 'Administrator' : 'Commenter'; ?></li>            
        </ul>
    </section>

    <section class="panel"> 
        <?php //show administrators stats about their posts, otherwise show commenter stats
        if(IS_ADMIN){ ?>
        <h2>Post Stats:</h2>
        <ul>
            <li>There are <b><?php echo count_posts(); ?></b> published posts on the blog</li>
            <li>You wrote <b><?php echo count_posts( USER_ID ); ?> Published Posts</b> </li>
            <li>You have <b><?php echo count_posts( USER_ID, 0 ); ?> Drafts</b> waiting to be published</li>
            <li>Your Most popular post: <br><b><?php echo most_popular_post( USER_ID ); ?></b>.</li>
        </ul>  
        <?php }else{ ?>
        <h2>Commenter Stats</h2>
        <ul>
            <li>You have written <b><?php echo count_user_comments(USER_ID, 1) ?></b> approved comments</li>
            <li>You have <b><?php echo count_user_comments(USER_ID, 0) ?></b> comments awaiting moderation</li>

        </ul>
        <?php } ?>
    </section>

    <section class="panel">
        <h2>General Announcements</h2>
        <ul>
            <li>You can make announcements to all users right here if you want to...
            </li>
        </ul>
    </section>     

</main>
    <?php 
// </body> and </html> are in the footer!
    include(ROOT_PATH . '/admin/admin-footer.php'); ?>