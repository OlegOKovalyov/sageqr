<?php
// global $user_ID; echo $user_ID;
$user_ID = $_POST['user_id'];
$usr_upload_dir = $_POST['usr_upload_dir'];

// WordPress environment 
require_once( dirname(__FILE__) . '/../../../../../../wp/wp-load.php' );

$i = 1; // number of tries when the file with the same name is already exists
 
$profilepicture = $_FILES['profilepicture']; print_r($profilepicture);
$new_file_path = $usr_upload_dir . '/' . $profilepicture['name'];
$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
 
if( empty( $profilepicture ) )
    die( 'File is not selected.' );
 
if( $profilepicture['error'] )
    die( $profilepicture['error'] );
 
if( $profilepicture['size'] > wp_max_upload_size() )
    die( 'It is too large than expected.' );
 
if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
    die( 'WordPress doesn\'t allow this type of uploads.' );
 
while( file_exists( $new_file_path ) ) {
    $i++;
    $new_file_path = $usr_upload_dir . '/' . $i . '_' . $profilepicture['name'];
}
 
// looks like everything is OK
if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {

    wp_redirect( home_url() . '/my-documents/' );
 
} 
