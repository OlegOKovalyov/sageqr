{{--
  Template Name: My Documents Template
--}}

@extends('layouts.docs')

<?php
require($_SERVER["DOCUMENT_ROOT"]."/wp/wp-load.php");
// require_once( get_template_directory() . '/views/modals/newfolder.php' );
// require_once( get_template_directory() . '/views/modals/renfile.php' );

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

$usr_upload_dir = get_theme_root() . '/sageqr/UserDir/' . $current_user_id;

if (!is_file($usr_dir) && !is_dir($usr_dir)) {
    wp_mkdir_p( $usr_upload_dir ); //create the directory
    chmod( $usr_upload_dir, 0777 ); //make it writable
    // wp_redirect( home_url() . '/my-documents/' );
}
else
{
    echo "{$dir} exists and is a valid dir";
}

if ( file_exists( $usr_upload_dir ) ) {

    $usr_entries = scandir( $usr_upload_dir, 1 );
}

for ($i=0; $i < count($usr_entries) - 2 ; $i++) {  
    $full_path_usr_file = $usr_upload_dir . '/' .$usr_entries[$i];
    if ( is_dir( $full_path_usr_file) ) {
        $usr_dirs[] = $usr_entries[$i]; 
    } else {
        $usr_files[] = $usr_entries[$i]; 
    }
}

?>

@section('content')
<?php 
require_once( get_template_directory() . '/views/modals/newfolder.php' );
require_once( get_template_directory() . '/views/modals/renfile.php' );
 ?>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->   

<div id="page" {{ body_class() }} >

    <div class="page-bar page_bar" id="page_title_bar">
        <table class="page-bar-table" style="margin-left: 10px; margin-right: 10px;">
            <tr>
                <td style="width: 20%">
                   <h4 class="page_title">{{ the_title() }}</h4>
                </td>

                <td style="width: 80%; display: none;"  id="fileaction">
                    <div id="files_bar" class="fileaction_icon">


                        <span><a href="javascript:;" id="favourite_btn" data-toggle="tooltip" data-placement="bottom" title="Add star"><i class="far fa-star icon-star doc_action_icon"></i></a></span>                    

                        <span><a href="#" id="share_btn" data-toggle="tooltip" data-placement="bottom" title="Share"><i class="fas fa-user-plus"></i></a></span>

                        <span><a href="#" id="file_rename" data-toggle="modal" data-target="#renFileModal" title="Rename"><i class="far fa-edit icon-note doc_action_icon"></i></a></span>

                        <span><a href="javascript:;" id="file_remove" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt"></i></a></span>

                        <span><a href="javascript:;"  id="view_btn" data-toggle="tooltip" data-placement="bottom" title="Preview"><i class="far fa-eye icon-eye"></i></a></span>

                        <span><a href="#" id="update_rev" data-toggle="tooltip" data-placement="bottom" title="Update revision"><i class="fas fa-cloud-upload-alt"></i></a></span>

<!-- <li class="nav-item fileinput-button"> -->
<!--     <form id="upload-form" action="<?php echo get_template_directory_uri() ?>/views/inc/revision_upload.php" method="post" enctype="multipart/form-data">
        <label class="nav-link">
            <i class="fas fa-cloud-upload-alt"></i> File<input id="file" type="file" style="display: none;" name="profilepicture" onchange="form.submit()" />
            <span><a href="#" id="update_rev" data-toggle="tooltip" data-placement="bottom" title="Update revision"><i class="fas fa-cloud-upload-alt"><input id="file" type="file" style="display: none;" name="profilepicture" onchange="form.submit()" /></i></a></span>
        </label>
        <input type="hidden" name="user_id" value='<?php echo $user_ID; ?>'>
        <input type="hidden" name="usr_upload_dir" value='<?php echo $usr_upload_dir; ?>'>
    </form>  -->                                           
<!-- </li>      -->




<form>
    <input type="file" name="my_file_upload" multiple="multiple" accept=".txt, image/*">
        <a href="#" class="upload_files_btn button">Загрузить файлы</a>
     <div class="ajax-reply"></div>
    <!-- <input type="hidden" name="user_id" value='<?php echo $user_ID; ?>'>
    <input type="hidden" name="usr_upload_dir" value='<?php echo $usr_upload_dir; ?>'>   -->   
</form>






                        <span><a href="javascript:void(0)" id="move_btn" data-toggle="tooltip" data-placement="bottom" title="Set expiry"><i class="far fa-clock"></i></a></span>

                        <span><a href="javascript:void(0)" id="move_btn" data-toggle="tooltip" data-placement="bottom" title="Move File"><i class="fas fa-arrows-alt"></i></a></span>

                    </div>
                </td>

            </tr>
        </table>
    </div>                                  

    <div id="contentdata" class="contentdata">
        <div id="created_folder" class="row created_folder">
            <?php for ($i=0; $i < count($usr_dirs) ; $i++) { ?>

            <div id="folder-bar" class="mix-inner folder-bar folder-double-click col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <div customId ="635" for="folder" id="folder_info_wrapper" class="folder_info_wrapper" >
                    <span class="folder_icon folder_icon_custom">
                        <i class="fas fa-folder"></i>
                    </span>
                    <span class="folder_name"  customId =635 id="folder_name" for="folder" >
                        <?php echo $usr_dirs[$i]; ?>
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
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 card_wrap">
                <!-- .card -->

                <div id="card_figure" class="card card-figure">
                    <!-- .card-figure -->
                    <figure class="figure">
                        <!-- .figure-img -->
                        <div class="figure-attachment">

                            <input type="hidden" name="folder_name" value='<?php echo $usr_files[$i]; ?>'>
                            <?php 
                                echo '<a href="#" class="fig_img" onclick="fileActions()"><img data-usr="'.$current_user_id.'" data-src="'.$usr_files[$i].'" src="'. get_home_url() . '/app/themes/sageqr/UserDir/'. $current_user_id . '/' . $usr_files[$i] . '" class="current" id="img_' . $i . '"></a>';
                            ?>
                        </div>
                        <!-- /.figure-img -->
                        <figcaption class="figure-caption">
                            <ul class="list-inline d-flex text-muted mb-0">
                                <li class="list-inline-item text-truncate mr-auto">
                                    <span><i class="fas fa-file-image mx-1"></i></span><span><?php echo $usr_files[$i]; ?></span> 
                                </li>
                            </ul>
                        </figcaption>
                    </figure>
                    <!-- /.card-figure -->

                </div>
                <!-- /.card -->
            </div>
            <!-- /grid column -->
            <?php } } else echo 'There are no file in your folder.'; ?>
        </div>

    </div>    

</div><!-- #page {{ body_class() }} -->
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->


<?php
/**
 *  Create New User Folder 
 */
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
}

?>


<!-- New Folder Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">

    <form action="<?= $_SERVER['REQUEST_URI'];?>" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <input type="text" name="folder" value="Untitle Folder"><br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
    </form>

  </div>
</div> -->

<script>
    // Show File Actions in Page Bar
    function fileActions() {
        var x = document.getElementById("fileaction"); 
        if (x.style.display === "none") {
            x.style.display = "block";         
        }
    }
</script>

<script>
    // Add/Replace Class Name 'active' to files in User folder
    var $ = jQuery;
    $(document).on('click','#uploaded_files .figure', function(){
        $('#uploaded_files .active').removeClass("active");
        $(this).addClass("active");
    });

    // Add/Replace Class Name 'active' to files in User folder
    // var figContainer = document.getElementById("uploaded_files");
    // var figures = figContainer.getElementsByClassName("figure"); console.log(figures);

    // for (var i = 0; i < figures.length; i++) {
    //     figures[i].addEventListener("click", function() {
    //     var currentf = document.getElementsByClassName("active");
    //     currentf[0].className = currentf[0].className.replace(" active", "");
    //     this.className += " active";
    //   });
    // }      
</script>

<script>
    var files; // переменная. будет содержать данные файлов

    // заполняем переменную данными, при изменении значения поля file 
    jQuery('input[type=file]').on('change', function(){
        files = this.files;
    });


// обработка и отправка AJAX запроса при клике на кнопку upload_files
jQuery('.upload_files_btn').on( 'click', function( event ){

    event.stopPropagation(); // остановка всех текущих JS событий
    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

    // ничего не делаем если files пустой
    if( typeof files == 'undefined' ) return;

    // создадим объект данных формы
    var data = new FormData();

    // заполняем объект данных файлами в подходящем для отправки формате
    jQuery.each( files, function( key, value ){
        data.append( key, value );
    });

    // добавим переменную для идентификации запроса
    data.append( 'my_file_upload', 1 );

    // AJAX запрос
    $.ajax({
        // action: 'myajax-updaterev',
        // nonce_code : the_ajax_script.nonce,        
        // url         : '/app/themes/sageqr/resources/views/inc/revision_uload.php',
        // url         : 'http://test5.local/app/themes/sageqr/resources/views/inc/revision_upload.php',
        url         : "<?php home_url() ?>"+'/app/themes/sageqr/resources/views/inc/revision_upload.php',
        // url         : 'inc/revision_upload.php',
        type        : 'POST', // важно!
        data        : data,
        cache       : false,
        dataType    : 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData : false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType : false, 
        // функция успешного ответа сервера
        success     : function( respond, status, jqXHR ){

            // ОК - файлы загружены
            if( typeof respond.error === 'undefined' ){
                // выведем пути загруженных файлов в блок '.ajax-reply'
                var files_path = respond.files;
                var html = '';
                $.each( files_path, function( key, val ){
                     html += val +'<br>';
                } )

                jQuery('.ajax-reply').html( html );
            }
            // ошибка
            else {
                console.log('ОШИБКА: ' + respond.error );
            }
        },
        // функция ошибки ответа сервера
        error: function( jqXHR, status, errorThrown ){
            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }

    });

});    
</script>




@endsection

