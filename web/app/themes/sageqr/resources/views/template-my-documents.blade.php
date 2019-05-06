{{--
  Template Name: My Documents Template
--}}

@extends('layouts.docs')

<?php
//echo "Hello!";
global $user_ID; //echo $user_ID;
 
if( !$user_ID ) {
    header('location:' . site_url() . '/login/');
    exit;
} else {
    $userdata = get_user_by( 'id', $user_ID );
}

?>

<?php

global $post;
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;
$usr_entries = array();
$usr_files = array();
$usr_dirs = array();

$usr_upload_dir = get_template_directory() . '/UserDir/' . $current_user_id;

if ( file_exists( get_template_directory() . '/UserDir/' . $current_user_id ) ) {

    $usr_entries = scandir($usr_upload_dir, 1);
}

for ($i=0; $i < count($usr_entries) - 2 ; $i++) {  
    $full_path_usr_file = $usr_upload_dir . '/' .$usr_entries[$i];
    if ( is_dir( $full_path_usr_file) ) {
        $usr_dirs[] = $usr_entries[$i]; 
    } else {
        $usr_files[] = $usr_entries[$i]; 
    }
}

// wp_mkdir_p( 'UserDir/testdir' );
// mkdir( 'UserDir/testdir2', 0777 );
// wp_mkdir_p( $usr_upload_dir . '/testdir' );

?>

@section('content')
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->   
<div class="page-title">
    <h4>{{ the_title() }}</h4>            
</div>
<div id="page" {{ body_class() }} >
         
    <div id="created_folder" class="row created_folder">
        <?php for ($i=0; $i < count($usr_dirs) ; $i++) { ?>
        <!-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div id="created_folder_col" class="created_folder-col">
                <?php 
                    //echo '<a href="#">' . $usr_dirs[$i]. '</a>';
                ?>
            </div>
        </div> -->
        <div id="folder-bar" class="mix-inner folder-bar folder-double-click col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <div customId ="635" for="folder" id="folder_info_wrapper" class="folder_info_wrapper" >
                <span class="folder_icon folder_icon_custom">
                    <!-- <i customId ="635" for="folder" id="folder_image" class="fa fa-folder doc_icon custom_folder" ></i> -->
                    <i class="fas fa-folder"></i>
                </span>
                <!-- <span class="folder_name"  customId =635 id="folder_name" for="folder" >Untitled Folder2</span> -->
                <span class="folder_name"  customId =635 id="folder_name" for="folder" >
                    <?php 
                        // echo '<a href="#">' . $usr_dirs[$i]. '</a>';
                        echo $usr_dirs[$i];
                        // wp_mkdir_p( 'UserDir/testdir' );
                    ?>
                </span>
            </div>
        </div>
        <?php } ?>
    </div>

    <div id="uploaded_files" class="row">
        <?php
        if( $usr_files ){
            for ($i=0; $i < count($usr_files) ; $i++) { 
        ?>    
        <!-- grid column -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
            <!-- .card -->

            <div class="card card-figure">
                <!-- .card-figure -->
                <figure class="figure">
                    <!-- .figure-img -->
                    <div class="figure-attachment">

                        <input type="hidden" name="folder_name" value='<?php echo $usr_files[$i]; ?>'>
                        <?php 
                            echo '<a href="#"><img src="'. get_template_directory_uri() . '/UserDir/'. $current_user_id . '/' . $usr_files[$i] . '" class="current"></a>';
                        ?>
                    </div>
                    <!-- /.figure-img -->
                    <figcaption class="figure-caption">
                        <ul class="list-inline d-flex text-muted mb-0">
                            <li class="list-inline-item text-truncate mr-auto">
                                <span><i class="fas fa-file-image mx-1" style="color: #d4565c;"></i></span><?php echo $usr_files[$i]; //echo basename($attachment->guid) ?> </li>
                            <li class="list-inline-item">
                                <a download href="../assets/images/card-img-1.jpg">


                                    <i class="fas fa-download mx-1"></i></a>
                            </li>
                        </ul>
                    </figcaption>
                </figure>
                <!-- /.card-figure -->

            </div>
            <!-- /.card -->
        </div>
        <!-- /grid column -->
        <?php } } else echo 'Вложений нет'; ?>
    </div>

</div><!-- #page {{ body_class() }} -->
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->



<?php
//для начала опишем функцию очистки данных от лишних пробелов и тегов
function clstr($data){
 return trim(strip_tags($data));
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//если метод обращения совпадает, то обрабатываем данные из массива $_POST
if($_SERVER['REQUEST_METHOD']=='POST'){
    // $folder = clstr($_POST['folder']);
    $folder = test_input($_POST['folder']);

    if (!is_file($folder) && !is_dir($folder)) {
        wp_mkdir_p( $usr_upload_dir . '/' . $_POST['folder'] );
        wp_redirect( home_url() . '/my-documents/' );
        //mkdir($dir); //create the directory
        //chmod($targetfilename, 0777); //make it writable
        //wp_redirect( home_url() . '/my-documents/' );
    }
    else
    {
        echo "{$folder} exists and is a valid folder";
    }

    
    // $phone = clstr($_POST['phone']);
    // $msg = clstr($_POST['message']);
        //проверим наши переменные на пустоту
        // if(!empty($name)&&!empty($phone)&&!empty($msg)){
        //     $to='poluchatel@mail.ru';
        //     $sub='Письмо с сайта';
        //     $text='Имя - '.$name.' Телефон - '.' Сообщение: '.$msg;
        //     //в переменную положим результат от функции mail false или true
        //     $status=mail($to, $sub, $text); 
        //     //положим результат в куки с временем хранения 10 сек
        //     setcookie('status_mail', $status, time()+10);
        //     header('Location:'.$_SERVER['REQUEST_URI']); 
        // }
}
// if($_COOKIE['status_mail']==true){
// echo "Сообщение отправлено";
// }
?>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <!-- <form action="<?php //get_template_directory() . 'inc/create_dir.php' ?>" method="post"> -->
    <!-- <form action="<?php //wp_mkdir_p( $usr_upload_dir . '/' . $_POST['folder'] ); ?>" method="post"> --><!-- WORKING!!! -->
    <!-- <form action="<?php //mkdir("testdir", 0777); ?>" method="post"> -->
    <!-- <form action="<?php //echo "hello" ?>" method="post"> -->
    <form action="<?= $_SERVER['REQUEST_URI'];?>" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">




    <!-- <form action="inc/create_dir.php" method="post"> -->
                <input type="text" name="folder" value="Untitle Folder"><br>
    <!-- <input type="submit"> -->
    <!-- </form>     -->

            <!-- <input type="text" name="folder" value="Untitle Folder"> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
    </form>
  </div>
</div>

@endsection