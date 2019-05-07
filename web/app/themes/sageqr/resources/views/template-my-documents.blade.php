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
<!-- <div class="page-title">
    <h4>{{ the_title() }}</h4>            
</div> -->
<div id="page" {{ body_class() }} >


<div class="page-bar page_bar" id="page_title_bar" style="display: none;">
    <table class="page-bar-table" style="margin-left: 10px; margin-right: 10px;">
        <tr>
            <td style="width: 20%">
               <h4 class="page_title">{{ the_title() }}</h4>
            </td>

            <td style="width: 80%;"  id="fileaction">
                <div id="files_bar" class="fileaction_icon">


                    <span><a href="javascript:;" id="favourite_btn" data-toggle="tooltip" data-placement="bottom" title="Add star"><i class="far fa-star icon-star doc_action_icon"></i></a></span>                    

                    <span><a href="#" id="share_btn" data-toggle="tooltip" data-placement="bottom" title="Share"><i class="fas fa-user-plus"></i></a></span>


                    <span><a href="#" id="rename_btn" data-toggle="tooltip" data-placement="bottom" title="Rename"><i class="far fa-edit icon-note doc_action_icon"></i></a></span>

 
                    <span><a href="javascript:removeFile();" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt"></i></a></span>


<!-- <div id="ajax-posts" class="row">
  <?php
  $args = array( 'post_type' => 'post', 
                  'posts_per_page' => 10,
                );
      $loop = new WP_Query($args);
      while ($loop->have_posts()) : $loop->the_post(); ?>
        <div class="small-12 large-4 columns">
          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
        </div>
  <?php 
    endwhile;
    wp_reset_postdata();
  ?>
</div>

<input type="hidden" id="totalpages" value="<?php echo $loop->max_num_pages ?>">
<div id="more_posts">Load More</div> -->




                    <span><a href="javascript:;"  id="view_btn" data-toggle="tooltip" data-placement="bottom" title="Preview"><i class="far fa-eye icon-eye"></i></a></span>

                    <span><a href="#expiry_modal" id="expiry_btn" data-toggle="tooltip" data-placement="bottom" title="Set expiry"><i id="set_expiry" class="fas fa-cloud-upload-alt"></i></a></span>

                    <span><a href="javascript:void(0)" id="move_btn" data-toggle="tooltip" data-placement="bottom" title="Move File"><i id="move_bar" class="far fa-clock"></i></a></span>

                    <span><a href="javascript:void(0)" id="move_btn" data-toggle="tooltip" data-placement="bottom" title="Move File"><i id="move_bar" class="fas fa-arrows-alt"></i></a></span>

                </div>
            </td>

        </tr>
    </table>
</div>                                  




<div id="contentdata" class="contentdata">
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

            <div id="card_figure" class="card card-figure">
                <!-- .card-figure -->
                <figure class="figure">
                    <!-- .figure-img -->
                    <div class="figure-attachment">

                        <input type="hidden" name="folder_name" value='<?php echo $usr_files[$i]; ?>'>
                        <?php 
                            echo '<a href="#" class="fig_img" onclick="fileActions()"><img src="'. get_template_directory_uri() . '/UserDir/'. $current_user_id . '/' . $usr_files[$i] . '" class="current"></a>';
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
}

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

<script>
/*var files; // переменная. будет содержать данные файлов

// заполняем переменную данными, при изменении значения поля file 
$('input[type=file]').on('change', function(){
    files = this.files;
});    */
</script>

<script>
    function fileActions() {

        var x = document.getElementById("page_title_bar"); 
        if (x.style.display === "none") {
            x.style.display = "block";         
        }
    
    }
</script>

<script>
    var figContainer = document.getElementById("uploaded_files");
    var figures = figContainer.getElementsByClassName("figure"); console.log(figures);
    // btns.classList.add("active");

    for (var i = 0; i < figures.length; i++) {
        figures[i].addEventListener("click", function() {
        var currentf = document.getElementsByClassName("active");
        currentf[0].className = currentf[0].className.replace(" active", "");
        this.className += " active";
      });
    }      
</script>

<script>
// function removeFile() {
//   alert("Remove File")
// }

// jQuery('.delete').live('click',function(){ 
//   removeFile( $(this).attr('id') );
// });

function removeFile(id){
    alert("File will be remove! Are you sure?");


var file; // переменная. будет содержать данные файлов

// заполняем переменную данными файлов, при изменении значения file поля
    file = this.file;
    console.log('file:')
    console.log(file.name);
    var data = new FormData(); console.log(data);
    // заполняем объект данных файлами в подходящем для отправки формате
    jQuery.each( file, function( key, value ){
        data.append( key, value );
    });    
    // добавим переменную идентификатор запроса
    data.append( 'file_to_remove', 1 );
    // AJAX запрос
    jQuery.ajax({
        url         : './inc/ajax-remove.php',
        type        : 'POST',
        data        : data,
        cache       : false,
        dataType    : 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData : false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType : false,
        // функция успешного ответа сервера
        success     : function( respond, status, jqXHR ){

            // ОК
            if( typeof respond.error === 'undefined' ){
                // файлы загружены, делаем что-нибудь

                // покажем пути к загруженным файлам в блок '.ajax-reply'

                var files_path = respond.files;
                var html = '';
                jQuery.each( files_path, function( key, val ){
                     html += val +'<br>';
                } )

                jQuery('.ajax-reply').html( html );
            }
            // error
            else {
                console.log('ОШИБКА: ' + respond.error );
            }
        },
        // функция ошибки ответа сервера
        error: function( jqXHR, status, errorThrown ){
            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }

    });

    // jQuery.ajax({
    //     url: 'deletefile.php?fileid='+id,
    //     success: function() {
    //         alert('File deleted.');
    //     }
    // });
}
</script>

<script>
(function($){

var files; // переменная. будет содержать данные файлов

// заполняем переменную данными файлов, при изменении значения file поля
$('#remove_btn').on('change', function(){
    files = this.files;
    console.log(files);
});


// обработка и отправка AJAX запроса при клике на кнопку upload_files
/*$('.upload_files').on( 'click', function( event ){

    event.stopPropagation(); // остановка всех текущих JS событий
    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

    // ничего не делаем если files пустой
    if( typeof files == 'undefined' ) return;

    // создадим данные файлов в подходящем для отправки формате
    var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });

    // добавим переменную идентификатор запроса
    data.append( 'my_file_upload', 1 );

    // AJAX запрос
    $.ajax({
        url         : './submit.php',
        type        : 'POST',
        data        : data,
        cache       : false,
        dataType    : 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData : false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType : false,
        // функция успешного ответа сервера
        success     : function( respond, status, jqXHR ){

            // ОК
            if( typeof respond.error === 'undefined' ){
                // файлы загружены, делаем что-нибудь

                // покажем пути к загруженным файлам в блок '.ajax-reply'

                var files_path = respond.files;
                var html = '';
                $.each( files_path, function( key, val ){
                     html += val +'<br>';
                } )

                $('.ajax-reply').html( html );
            }
            // error
            else {
                console.log('ОШИБКА: ' + respond.error );
            }
        },
        // функция ошибки ответа сервера
        error: function( jqXHR, status, errorThrown ){
            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }

    });

});*/


})(jQuery)
</script>


@endsection

