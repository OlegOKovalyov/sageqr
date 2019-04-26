{{--
  Template Name: My Profile Template
--}}

@extends('layouts.sign')

<?php
global $user_ID; echo $user_ID;
 
if( !$user_ID ) {
    header('location:' . site_url() . '/login/');
    exit;
} else {
    $userdata = get_user_by( 'id', $user_ID );
}
?>


<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    @include('dashboard.navbar')
    @include('dashboard.left-sidebar')

<body class="error404 wp-custom-logo hfeed">
    
    <div id="page" {{ body_class() }} >
        <div class="content">
            <div class="container">
                <div class="row-wrap my-4 offset-md-2">

                    <form id="myprofile" action="<?php echo get_template_directory_uri() ?>/views/inc/profile-update.php" method="POST" oninput='confirm.setCustomValidity(confirm.value != password.value ? "Passwords do not match." : "")'>

                        <div class="form-header">
                            <div class="form-header__title">
                                <i class="fa fa-user"></i> Personal Info
                            </div>
                        </div>
                        <div class="form-body">
                          <div class="form-group row">
                            <label for="inputName" class="col-lg-4 col-form-label">Name
                                <span class="required" area-required="true">*</span>
                            </label>
                            <div class="col-lg-5">
                              <input type="name" class="form-control" id="inputName" value="{{ $userdata->display_name }}" name="display_name">

                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputEmail" class="col-lg-4 col-form-label">Email
                            </label>
                            <div class="col-lg-5">
                              <input type="email" class="form-control" id="inputEmail" placeholder="{{ $userdata->user_email }}" name="email" readonly>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputPassword" class="col-lg-4 col-form-label">New Password</label>
                            <div class="col-lg-5">
                              <input type="password" class="form-control" id="inputPassword3" placeholder="" name="password">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="confirmPassword" class="col-lg-4 col-form-label">Confirm Password</label>
                            <div class="col-lg-5">
                              <input type="password" class="form-control" id="inputPassword3" placeholder="" name="confirm">
                            </div>
                          </div>
                        </div>

                        <div class="form-header">
                            <div class="form-header__title">
                                <i class="fa fa-user"></i> Email Notifications
                            </div>
                        </div>          

                        <div class="form-body">
                          <div class="form-group row">
                            <div class="col-lg-4 email-notif">Send me email notifications when comments are added by my reviewers</div>
                            <div class="col-lg-5">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" value="1">
                                <label class="form-check-label" for="gridCheck1"></label>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="form-actions">
                          <div class="form-group row">
                            <div class="col-lg-4"> </div> 
                            <div class="col-lg-5">
                              <button type="submit" class="btn btn-info green">Save</button>
                            </div>
                          </div>   
                        </div>

                        <?php
                        // Form success/error notifications
                        if( isset($_GET['status']) ) :
                            switch( $_GET['status'] ) :
                                case 'ok':{
                                    echo '<div class="alert alert-success" role="alert">Changes have been saved.</div>';
                                    break;
                                }
                                case 'mismatch':{
                                    echo '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
                                    break;
                                }
                            endswitch;
                        endif;
                        ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>