{{--
  Template Name: Register Template
--}}

@extends('layouts.sign')

@section('content')
  {{--@while(have_posts())
    {!! the_post() !!}
    @include('partials/content-single')
  @endwhile --}}

<?php 
$success = '';
$error = '';
global $wpdb, $PasswordHash, $current_user, $user_ID;
 
if(isset($_POST['task']) && $_POST['task'] == 'register' ) {

    $full_name = $wpdb->esc_like(trim($_POST['full_name']));
    $last_name = $full_name;
    $password = $wpdb->esc_like(trim($_POST['password']));
    $confirm = $wpdb->esc_like(trim($_POST['confirm']));
    $email = $wpdb->esc_like(trim($_POST['email']));
    // $username = $wpdb->esc_like(trim($_POST['username']));
    $username = $full_name;
    
    if( $email == "" || $password == "" || $confirm == "" || $username == "" || $full_name == "" || $last_name == "") {
        $error = 'Please don\'t leave the required fields.';
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else if(email_exists($email) ) {
        $error = 'Email already exist.';
    } else if($password <> $confirm ){
        $error = 'Password do not match.';      
    } else {
 
        $user_id = wp_insert_user( array ('full_name' => apply_filters('pre_user_full_name', $full_name), 'last_name' => apply_filters('pre_user_full_name', $last_name), 'user_pass' => apply_filters('pre_user_user_pass', $password), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $email), 'role' => 'subscriber' ) );
        if( is_wp_error($user_id) ) {
            $error = 'Error on user creation.';
        } else {
            do_action('user_register', $user_id);
            if ( ! wp_mkdir_p( get_template_directory() . "/UserDir/" . $user_id ) ) {
                echo "Не удалось создать каталог " . get_template_directory() . '/UserDir/' . $user_id;
            }

            echo "Удалось создать каталог: " . get_template_directory() . "/UserDir/" . $user_id;
            $success = 'You\'re successfully registered';
        }
    }
}

?>

<div class="logo">
	<a href="/login/">
		<img src="@asset('images/logo-big.png')">
	</a>
</div>

<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->
<form class="splash-container" method="post">
    <div class="card bg-transparent border-0 shadow-none">
        <div class="card-header">
            <h3 class="form-title">Sign Up</h3>
            <p class="after-header">Enter your personal details below: </p>
        </div>
        <div class="alert-msg"><p><?php if($success != "") { ?> 
            <div class="alert alert-success" role="alert">
              {{ $success }}
            </div>
            <?php } if($error!= "") { ?>
                <div class="alert alert-danger" role="alert">
                  {{ $error }}
                </div> 
            <?php } ?></p>
        </div>        
        <div class="card-body">
            <div class="form-group">
            	<div class="input-icon">
              	<i class="fa fa-font"></i>
                  <input class="form-control form-control-lg" type="text" name="full_name" required="" placeholder="Full Name" autocomplete="off">
            	</div>
            </div>
            <div class="form-group">
            	<div class="input-icon">
            		<i class="fa fa-envelope"></i>
                	<input class="form-control form-control-lg" type="email" name="email" required="" placeholder="E-mail" autocomplete="off">
            	</div>
            </div>
            <div class="form-group">
            	<div class="input-icon">
            		<i class="fa fa-lock"></i>
                	<input class="form-control form-control-lg" id="pass1" type="password" name="password" required="" placeholder="Password">
            	</div>
            </div>
            <div class="form-group confirm">
            	<div class="input-icon">
            		<i class="fa fa-check"></i>
                	<input class="form-control form-control-lg" type="password" name="confirm" required="" placeholder="Retype password">
                </div>
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Lfvu54UAAAAAMBAGk331VSsaSH__6R6rJmQptfU"></div>
            </div>
            <?php
             
              if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
              {
                    $secret = '6Lfvu54UAAAAAJhxGF0MFCQdki6oGR5868jooMNB';
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                    $responseData = json_decode($verifyResponse);
                    if($responseData->success)
                    {
                        $succMsg = 'Your contact request have submitted successfully.';
                    }
                    else
                    {
                        $errMsg = 'Robot verification failed, please try again.';
                    }
               }
            ?>        
            <div class="form-group form-actions">
            	<button id="register-back-btn" class="btn-primary" login-url="/login/" type="button" onclick="window.location.href='/login/'"><i class="far fa-arrow-alt-circle-left"></i> Login</button>
            	<button id="register-submit-btn-btn" class="btn-primary" login-url="#" type="submit" name="btnregister">Register <i class="far fa-arrow-alt-circle-right"></i></button>
            	<input type="hidden" name="task" value="register" />
            </div>
        </div>
    </div>
</form>

@endsection  

<!-- <script src='https://www.google.com/recaptcha/api.js' async defer > -->