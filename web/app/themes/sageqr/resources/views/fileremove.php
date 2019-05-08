<?php

$path = $_POST['path'];
echo $path;
$return_text = 0;

unlink('http://test5.local/app/themes/sageqr/resources/UserDir/14/2_Contacts.jpg');
unlink('../UserDir/14/2_Contacts.jpg');

// Check file exist or not
if( file_exists($path) ){

  // Remove file 
  unlink($path);
  unlink('http://test5.local/app/themes/sageqr/resources/UserDir/14/2_Contacts.jpg');
  // Set status
  $return_text = 1;
}else{

  // Set status
  $return_text = 0;
}

// Return status
echo $return_text;