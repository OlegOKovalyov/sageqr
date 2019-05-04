{{--
  Template Name: My Documents Template
--}}

@extends('layouts.sign')

<?php
//echo "Hello!";
global $user_ID; echo $user_ID;
 
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
$usr_files = array();

if ( file_exists( get_template_directory() . '/UserDir/' . $current_user_id ) ) {
    echo "Directory " . get_template_directory() . '/UserDir/' . $current_user_id . " существует";
    $usr_upload_dir = get_template_directory() . '/UserDir/' . $current_user_id; echo $usr_upload_dir;
    $usr_files = scandir($usr_upload_dir, 1);
    print_r($usr_files);
} else {
    echo "Directory " . get_template_directory() . '/UserDir/' . $current_user_id . " не существует";
    $usr_upload_dir = wp_mkdir_p( get_template_directory() . "/UserDir/" . $current_user_id );
}

//$usr_upload_dir = get_template_directory() . '/UserDir/' . $current_user_id; echo $usr_upload_dir;


$attachments = get_children( array(
    'post_parent'    => null,
    'order'          => 'ASC',
    'post_mime_type' => 'image',
    'post_type'      => 'attachment',
    'post_title'     => 'My Documents',
    'author'    => $current_user_id,
) );
?>


<body class="error404 wp-custom-logo hfeed">

    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        @include('dashboard.navbar')
        @include('dashboard.left-sidebar')

        <div class="page-title">
            <div class="container">

                <h4>{{ the_title() }}</h4>            
            </div>
        </div>
        <div id="page" {{ body_class() }} >
            <div class="content">
                <div class="container">
                    <div class="row-wrap my-4 offset-md-2">

                        <form action="<?php echo get_template_directory_uri() ?>/views/inc/process_upload.php" method="post" enctype="multipart/form-data">
                            Add New File: <input type="file" name="profilepicture" size="25" />
                            <input type="hidden" name="user_id" value='<?php echo $user_ID; ?>'>
                            <input type="hidden" name="usr_upload_dir" value='<?php echo $usr_upload_dir; ?>'>
                            <input type="submit" name="submit" value="Submit" />
                        </form>
                    </div>

                    <div class="row">
                        <?php
                        if( $usr_files ){
                            //foreach( $usr_files as $usr_file ){     
                            for ($i=0; $i < count($usr_files) - 2 ; $i++) { ?>    
                        <!-- grid column -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                            <!-- .card -->

                            <div class="card card-figure">
                                <!-- .card-figure -->
                                <figure class="figure">
                                    <!-- .figure-img -->
                                    <div class="figure-attachment">
                                        <!-- <span class="fa-stack fa-lg">
                                                   <i class="fa fa-square fa-stack-2x text-primary"></i>
                                                   <i class="fa fa-file-pdf fa-stack-1x fa-inverse"></i>
                                        </span> -->
                                        <?php 
                                            // $image_src = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )[0]  ?: wp_get_attachment_image_src( $attachment->ID, 'full' )[0];
                                            // $image_desc = $attachment->post_content ?: $attachment->post_title;
                                            // echo '<a href="#"><img src="'. $image_src .'" alt="'. esc_attr( $image_desc ) .'" class="current"></a>';
                                            // echo '<a href="#"><img src="'. $usr_upload_dir . '/'. $usr_files[0] . '" class="current"></a>';
                                        $full_path_usr_file = $usr_upload_dir . '/' .$usr_files[$i];
                                        if (exif_imagetype( $full_path_usr_file ) ) {
                                            // echo 'Картинка';
                                        // }
                                            echo '<a href="#"><img src="'. get_template_directory_uri() . '/UserDir/'. $current_user_id . '/' . $usr_files[$i] . '" class="current"></a>';
                                        }
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

                </div><!-- .container -->
            </div><!-- .content -->
        </div><!-- #page {{ body_class() }} -->
    </div><!-- .dashboard-main-wrapper -->
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->

</body>
</html>