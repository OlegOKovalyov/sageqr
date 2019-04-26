<?php 

// For right redirects
$url = explode("?",$_SERVER['HTTP_REFERER']);
 
// Connect to WordPress
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-load.php' ); 

if( !is_user_logged_in() ) exit;
 
// Get User object with its data
$user_ID = get_current_user_id(); echo $user_ID; echo "<br>";
$user = get_user_by( 'id', $user_ID ); var_dump($user); echo "<br>"; 

// Handle passwords
if( $_POST['password'] || $_POST['confirm'] )  {

    if( $_POST['password'] == $_POST['confirm'] ){

            wp_set_password( $_POST['password'], $user_ID );
            $creds['user_login'] = $user->user_login;
            $creds['user_password'] = $_POST['password'];
            $creds['remember'] = true;
            $user = wp_signon( $creds, false );

    } else {
        header('location:' . $url[0] . '?status=mismatch');
        exit;
    }
} 

// Handle name
if( $_POST['display_name'] ) {

    wp_update_user( array( 
            'ID' => $user_ID, 
            'display_name' => $_POST['display_name']
    ));
}

header('location:' . $url[0] . '?status=ok');
exit;
