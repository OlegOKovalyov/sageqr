<?php

if( isset( $_POST['my_file_upload'] ) ) { 

    $uploaddir = '../../../UserDir/' . $_POST ["user_id"];

    // Create folder if it is absent
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // Received files
    $done_files = array();
    $i = 1;
    $new_file_path = realpath($uploaddir);

    //  Remove file from the temporary folder to the defined folder
    foreach( $files as $file ){

        $file_name = $file['name'];
        $new_file_path = $new_file_path . '/' . $file_name;

        while ( file_exists( $new_file_path ) ) {
            $new_file_path = realpath($uploaddir) . '/' . $i . '_' . $file_name;
            $i++;
            chmod($new_file_path, 0777);
        }

        // looks like everything is OK
        if( move_uploaded_file( $file['tmp_name'], $new_file_path ) ) {
            $done_files[] = realpath( $new_file_path );
        }         

    }

    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

    die( json_encode( $data ) );
}




