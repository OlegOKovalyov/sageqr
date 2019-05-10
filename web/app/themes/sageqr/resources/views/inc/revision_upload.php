<?php

if( isset( $_POST['my_file_upload'] ) ) { 


    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    $uploaddir = '../../../UserDir/' . $_POST ["user_id"];

    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();
    $i = 1;
    $new_file_path = realpath($uploaddir); //echo $new_file_path;

    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){

        $file_name = $file['name'];
        $new_file_path = $new_file_path . '/' . $filename;
        // echo '$file_name = ' . $file_name;

        while ( file_exists( $new_file_path ) ) {
            // echo "File with this name alredy exists!";
            // $i++;
            // $file_name =  $i . '_' . $file_name ;
            // $new_file_path = $uploaddir . '/' . $file_name;
            $new_file_path = realpath($uploaddir) . '/' . $i . '_' . $file_name;
            $i++;

        }

        // looks like everything is OK
        // if( move_uploaded_file( $file['tmp_name'], $new_file_path ) ) {
        if( move_uploaded_file( $file['tmp_name'], $new_file_path ) ) {
            // $new_file_path = $uploaddir . '/' . $i . '_' . $profilepicture['name'];
            $done_files[] = realpath( $new_file_path );
            // var_dump($done_files);
            // chmod($new_file_path, 0755);
            // chmod($new_file_path, 0777);
            // wp_redirect( home_url() . '/my-documents/' );
         
        }         

        // if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
        //     $done_files[] = realpath( "$uploaddir/$file_name" );
        // }
    }

    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
    //$data = $new_file_path ? array('files' => $new_file_path ) : array('error' => 'Ошибка загрузки файлов.');

    die( json_encode( $data ) );
}




