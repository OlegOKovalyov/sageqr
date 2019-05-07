<?php

if( isset( $_POST['file_to_remove'] ) ){  
    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    global $post;
    $current_user = wp_get_current_user(); echo $current_user;
    $current_user_id = $current_user->ID;
    $usr_upload_dir = get_template_directory() . '/UserDir/' . $current_user_id;



    //$uploaddir = './uploads'; // . - текущая папка где находится submit.php
    
    // cоздадим папку если её нет
    //if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();

    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){
        $file_name = cyrillic_translit( $file['name'] );

        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
            $done_files[] = realpath( "$uploaddir/$file_name" );
        }
    }
    
    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
    
    die( json_encode( $data ) );
}