<?php 
require( '../db-config.php' );
include_once( ROOT_PATH . '/functions.php' );
require( ROOT_PATH . '/admin/admin-header.php' ); 
include( ROOT_PATH . '/admin/admin-nav.php' ); 

//Begin Image Upload Parser
if($_POST['did_upload']){
    //the folder where images will be stored
    $upload_path = ROOT_PATH . '/uploads' ;

    //what sizes do we need to generate
    $sizes = array(
        'thumb'     => 150,
        'medium'    => 300,
        );

    //extract the file from the form
    $uploadedfile = $_FILES['uploadedfile']['tmp_name'];
    
    //validate - make sure it is an image
    list($width, $height) =  getimagesize($uploadedfile);
    //if the width or height are 0, this is not an image
    if( $width > 0 AND $height > 0 ){    

        //what type of image is it?
        $filetype = $_FILES['uploadedfile']['type'];

        switch( $filetype ){
            case 'image/gif':
                $source = imagecreatefromgif($uploadedfile);
            break;

            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $source = imagecreatefromjpeg($uploadedfile);
            break;

            case 'img/png':
                ini_set( 'memory_limit', '16M' );
                $source = imagecreatefrompng($uploadedfile);
                ini_restore('memory_limit');
            break;

            default:
                $message = 'The only allowed filetypes are png, gif and jpg';
                $status = 'error';
        }//end of filetype switch

        //resize and save the images (loop)
        $uniquestring = sha1(microtime());
        foreach( $sizes AS $size_name => $size_width ){
            //if the original image is smaller than the target size, keep it at the original size
            if( $width < $size_width ){
                $new_width = $width;
                $new_height = $height;
            }else{
                //large image - calculate new width and height
                $new_width = $size_width;
                $new_height = ($height/$width) * $new_width;
            }

            $tmp_canvas = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($tmp_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $filename = $upload_path . '/' . $uniquestring . '_' . $size_name . 
                        '.jpg';
            $did_save = imagejpeg($tmp_canvas, $filename, 70);
        }//end foreach

        //if it saved the file, add it to the DB
        if($did_save){

            //DELETE OLD FILE
            //look up the old image name
            $query_oldfile = "SELECT userpic FROM users where user_id = " . USER_ID . " LIMIT 1";
            $result_oldfile = $db->query($query_oldfile);
            if($result_oldfile->num_rows == 1){
                $row_oldfile = $result_oldfile->fetch_assoc();
                //delete old files
                foreach ($sizes as $size_name => $size_width) {
                   $old_file = ROOT_PATH . '/uploads/' . $row_oldfile['userpic'] . '_' . $size_name . '.jpg'  ;
                  //Delete the file from the directory with unlink()
                  @unlink($old_file);
                }              
            }
            //END DELETE OLD FILE


            //add this userpic for the logged in person
            $query = "UPDATE users
                        SET userpic = '$uniquestring'
                        WHERE user_id = " . USER_ID ;
            $result = $db->query($query);
            if( ! $result ){
                $message = $db->error;
                $status = 'error';
            }
            if($db->affected_rows == 1){
                $message = 'Success! Your userpic has been updated';
                $status = 'success';
            }else{
                $message = 'Sorry, your userpic could not be changed';
                $status = 'error';
            }
        }//end if did_save
        else{
            $message = 'Sorry, your image could not be saved. Try again.';
            $status = 'error';
        }
        
        //clean up!
    
    }// end if this image has pixels
    else{
        $message = 'The file you uploaded is not an image';
        $status = 'error';
    }
}//end of parser
?>  

<main role="main">
    <section class="panel important">
     <h2>Edit Your Profile</h2>
     <?php 
        if( isset($message) ){
            echo '<div class="feedback ' . $status . '">';
            echo $message;
            echo '</div>';
        } ?>
     <div class="twothirds box">


         <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" 
             enctype="multipart/form-data">

             <input type="file" name="uploadedfile">

             <input type="submit" value="Update Profile Picture">
             <input type="hidden" name="did_upload" value="1">

         </form>
     </div>

     <div class="onethird box">
           <?php show_userpic(USER_ID, 'medium'); ?>         
     </div>
 </section>   

</main>
<?php 
// </body> and </html> are in the footer!
include(ROOT_PATH . '/admin/admin-footer.php'); ?>