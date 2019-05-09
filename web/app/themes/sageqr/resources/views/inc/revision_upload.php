<?php

/*if( isset( $_POST['my_file_upload'] ) ) { 


    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    $uploaddir = '../../../UserDir/' . $_POST ["user_id"];

    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();
    $i = 0;

    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){
        $file_name = $file['name'];
        $new_file_path = $uploaddir . '/' . $file_name;

        echo '$file_name = ' . $file_name;

        while ( file_exists( $new_file_path ) ) {
            echo "File with this name alredy exists!";
            $i++;
            $file_name =  $i . '_' . $file_name ;
            $new_file_path = $uploaddir . '/' . $file_name;

        }

        // looks like everything is OK
        if( move_uploaded_file( $file['tmp_name'], $new_file_path ) ) {
            $done_files[] = realpath( "$uploaddir/$file_name" );
            // chmod($new_file_path, 0755);
            chmod($new_file_path, 0777);
            wp_redirect( home_url() . '/my-documents/' );
         
        }         

        // if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
        //     $done_files[] = realpath( "$uploaddir/$file_name" );
        // }
    }

    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

    die( json_encode( $data ) );
}*/




if( isset( $_POST['my_file_upload'] ) ) { 


    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    $uploaddir = '../../../UserDir/' . $_POST ["user_id"];

    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();
    $i = 0;

    $profilepicture = $_FILES['my_file_upload']; //print_r($profilepicture);
    $new_file_path = $usr_upload_dir . '/' . $profilepicture['name'];
    $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );

    // переместим файлы из временной директории в указанную
/*    foreach( $files as $file ){
        $file_name = $file['name'];
        $new_file_path = $uploaddir . '/' . $file_name;

        echo '$file_name = ' . $file_name;

        while ( file_exists( $new_file_path ) ) {
            echo "File with this name alredy exists!";
            $i++;
            $file_name =  $i . '_' . $file_name ;
            $new_file_path = $uploaddir . '/' . $file_name;

        }

        // looks like everything is OK
        if( move_uploaded_file( $file['tmp_name'], $new_file_path ) ) {
            $done_files[] = realpath( "$uploaddir/$file_name" );
            // chmod($new_file_path, 0755);
            chmod($new_file_path, 0777);
            wp_redirect( home_url() . '/my-documents/' );
         
        }         

        // if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
        //     $done_files[] = realpath( "$uploaddir/$file_name" );
        // }
    }*/


    while( file_exists( $new_file_path ) ) {
        $i++;
        $new_file_path = $usr_upload_dir . '/' . $i . '_' . $profilepicture['name']; //echo $new_file_path;
        //$new_file_path = $usr_upload_dir . '/'. $profilepicture['name'] . ' (' . $i . ')' ; //echo $new_file_path;
    }
     
    // looks like everything is OK
    if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {

        // chmod($new_file_path, 0755);
        chmod($new_file_path, 0777);
        wp_redirect( home_url() . '/my-documents/' );
     
    } 


    // $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
    $data = $done_files ? $new_file_path : array('error' => 'Ошибка загрузки файлов.');

    

    die( json_encode( $data ) );
}

