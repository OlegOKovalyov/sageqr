<?php
// wp_redirect( site_url() . '/my-documents/' );
echo "hello"; echo $_POST['folder'];
wp_mkdir_p( $usr_upload_dir . '/' . $_POST['folder'] );
// global $current_user;
// get_currentuserinfo();
// $upload_dir = wp_upload_dir(); 
// $user_dirname = $upload_dir['basedir'] . '/' . $current_user->user_login;
// if(!file_exists($user_dirname)) wp_mkdir_p($user_dirname);

// wp_mkdir_p( $usr_upload_dir . '/testdir2' );

echo "hello";
wp_mkdir_p("testdir");
$user_ID = get_current_user_id(); echo $user_ID;
// define("PATH", "/home/born05/htdocs/swish_s/Swish");
define("PATH", "/resources/views/UserDir/" . $user_ID);

$test = "set";
// $_POST["dirname"] = "test";

if (isset($test)) {
  //get value of inputfield
  $dir = $_POST['folder'];
  //set the target path ??

$targetfilename = PATH . '/' . $dir;

if (!is_file($dir) && !is_dir($dir)) {
    mkdir($dir); //create the directory
    chmod($targetfilename, 0777); //make it writable
    wp_redirect( home_url() . '/my-documents/' );
}
else
{
    echo "{$dir} exists and is a valid dir";
}

// wp_redirect( home_url() . '/my-documents/' );
// wp_redirect( site_url() . '/my-documents/' );