<?php
// // global $user_ID; echo $user_ID;
// $user_ID = $_POST['user_id'];
// $usr_upload_dir = $_POST['usr_upload_dir'];

// // WordPress environment 
// require_once( dirname(__FILE__) . '/../../../../../../wp/wp-load.php' );

// $i = 1; // number of tries when the file with the same name is already exists
 
// $profilepicture = $_FILES['profilepicture']; print_r($profilepicture);
// $new_file_path = $usr_upload_dir . '/' . $profilepicture['name'];
// $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
 
// if( empty( $profilepicture ) )
//     die( 'File is not selected.' );
 
// if( $profilepicture['error'] )
//     die( $profilepicture['error'] );
 
// if( $profilepicture['size'] > wp_max_upload_size() )
//     die( 'It is too large than expected.' );
 
// if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
//     die( 'WordPress doesn\'t allow this type of uploads.' );
 
// while( file_exists( $new_file_path ) ) {
//     $i++;
//     $new_file_path = $usr_upload_dir . '/' . $i . '_' . $profilepicture['name']; echo $new_file_path;
// }
 
// // looks like everything is OK
// if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {

//     // chmod($new_file_path, 0755);
//     chmod($new_file_path, 0777);
//     // wp_redirect( home_url() . '/my-documents/' );
 
// } 

// $user_ID = $_POST['user_id'];
// $usr_upload_dir = $_POST['usr_upload_dir'];
// $currentUser = $_POST['currentUser'];

// echo 'HELLO!';
if( isset( $_POST['my_file_upload'] ) ){  
    // check_ajax_referer( 'myajax-nonce', 'nonce_code' );

    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    //$uploaddir = './uploads'; // . - текущая папка где находится submit.php
    $uploaddir = '../../../UserDir'; // . - текущая папка где находится submit.php !!! RIGHT PATH !!!

    // $uploaddir = get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/';
    // $uploaddir = get_theme_root() . '/sageqr/UserDir/';
    // $uploaddir = 'http://test5.local/app/themes/sageqr/UserDir/';
// echo 'HELLO!2';
    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
// echo 'HELLO!3';
    $files      = $_FILES; // полученные файлы
    $done_files = array(); //print_r($done_files);
// echo 'HELLO!4';
    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){
        $file_name = $file['name'];

        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
            $done_files[] = realpath( "$uploaddir/$file_name" );
        }
    }

    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

    die( json_encode( $data ) );
}