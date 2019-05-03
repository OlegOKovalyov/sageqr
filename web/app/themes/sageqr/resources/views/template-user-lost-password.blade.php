{{--
  Template Name: Lost Password
--}}

@extends('layouts.sign')

<?php
global $wpdb;

if(isset($_POST['forgot_pass_Sbumit'])) {
	if ( isset($_POST['emailToreceive']) && empty($_POST['emailToreceive']) )
	 	$errors['userName'] = __("Email shouldn't be empty.");
	else{
	 	$emailToreceive = $_POST['emailToreceive']; 
	 	$user_input = esc_sql(trim($emailToreceive));

		if ( strpos($user_input, '@') ) {
		 	$user_data = get_user_by( 'email', $user_input ); 
		 	if(empty($user_data) ) {
		 		$errors['invalid_email'] = 'Invalid E-mail address!'; 
		 	}
		} else {
		 	$user_data = get_user_by( 'login', $user_input ); 
		 	if(empty($user_data) ) { 
		 		$errors['invalid_usename'] = 'Invalid Username!'; 
		 	}
		}

		if(empty($errors)) { 
		  	if(kv_forgot_password_reset_email($user_data->user_email)) {
		  	 	$success['reset_email'] = "We have just sent you an email with Password reset instructions.";
		  	} else {
		  	 	$errors['emailError'] = "Email failed to send for some unknown reason."; 
		  	} //emailing password change request details to the user 
		}
	}
}

if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {

	$reset_key = $_GET['key'];
	$user_login = $_GET['login'];

 	$user_data = $wpdb->get_row("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = '".$reset_key."' AND user_login = '". $user_login."'");

 	echo '<div><p style="color:#155724; background-color:#d4edda; padding: 6px 12px; text-align:center">New password has been sent to your E-mail.</p></div>';


	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	if(!empty($reset_key) && !empty($user_data)) {

			if ( kv_rest_setting_password( $reset_key, $user_login, $user_email, $user_data->ID ) ) {

			 	$errors['emailError'] = "Email failed to sent for some unknown reason"; 

			} else {

				$redirect_to = get_site_url()."/login/?action=reset_success";
				wp_safe_redirect($redirect_to);
				exit();

			}
	}

 	else exit('Not a Valid Key.'); 
 }
?>

<div class="btn-wrap"></div>

<div class="logo">
	<a href="/">
		<img src="@asset('images/logo-big.png')">
	</a>
</div>

<!-- ============================================================== -->
<!-- forgot password form  -->
<!-- ============================================================== -->
<form id="forgot_password" class="splash-container" role="form" action="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" method="post" >
	<div class="card bg-transparent border-0 shadow-none mb-3">
        <div class="card-header">
            <h3 class="form-title">Forgot Password ?</h3>
            <p class="after-header">Enter your e-mail address below to reset your password.</p>
        </div>

        <div class="alert-msg">
        	<p>
	        	@if (!empty($success))
		            <div class="alert alert-success" role="alert">
		            	@foreach ($success as $suc)
						    {{ $suc }}
						@endforeach
		            </div>
	            @endif
	            @if(!empty($errors))
	                <div class="alert alert-danger" role="alert">
		            	@foreach ($errors as $err)
						    {{ $err }}
						@endforeach	                	
	                </div> 
	            @endif
        	</p>
        </div> 			      
       		
		<div class="card-body">
            <div class="form-group">
            	<div class="input-icon">
            		<i class="fa fa-envelope"></i>
                	<input class="form-control form-control-lg" type="email" name="emailToreceive" placeholder="Email" autocomplete="off">
            	</div>
            </div>			

            <div class="form-group form-actions">
            	<button id="register-back-btn" class="btn-primary" login-url="/login/" type="button" onclick="window.location.href='/login/'"><i class="far fa-arrow-alt-circle-left"></i> Login</button>
            	<input type="hidden" name="forgot_pass_Sbumit" value="kv_yes" >
            	<button id="getpassw-submit-btn-btn" class="btn-primary" login-url="#" type="submit" name="submit">Submit <i class="far fa-arrow-alt-circle-right"></i></button>
            </div>			
		</div>
	</div>	
</form>

<?php 
/**
 * Sent a reset email to user from Forgot Password page.
 */
function kv_forgot_password_reset_email($user_input) {
    global $wpdb;

    $user_data = get_user_by( 'email', $user_input ); 
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
 
    $key = $wpdb->get_var("SELECT user_activation_key FROM $wpdb->users WHERE user_login ='".$user_login."'");
    if(empty($key)) {
    //generate reset key
         $key = wp_generate_password(20, false);
         $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
     }
 
    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
    $message .= get_option('siteurl') . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was an error, just ignore this email as no action will be taken.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= tg_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login);

    if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
    	$msg = false ; 
    } else {
    	$msg = true;
    } 

    return $msg ; 
}

/**
 * Handle the new password generation and email to the requested user.
 */
function kv_rest_setting_password($reset_key, $user_login, $user_email, $ID) {
 
    $new_password = wp_generate_password(12, false); //you can change the number 12 to whatever length needed for the new password
     wp_set_password( $new_password, $ID ); //mailing the reset details to the user
 
    $message = __('Your new password for the account at:') . "\r\n\r\n";
    $message .= get_bloginfo('name') . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
    $message .= __('You can now login with your new password at: ') . "\r\n\r\n";
    $message .= get_option( 'siteurl' ) . "/login/";

    if ( $message && !wp_mail($user_email, 'Your New Password to login into Quickrev Site', $message) ) {
        $msg = false; 
     } else {
        $msg = true; 
        $redirect_to = get_site_url()."/login/?action=reset_success";
        exit();
    } 

    return $msg; 
}

/**
 * Validate the url
 */
function tg_validate_url() {
    global $post;
    $page_url = esc_url(get_permalink( $post->ID ));
    $urlget = strpos($page_url, "?");
    if ($urlget === false) {
        $concate = "?";
    } else {
        $concate = "&";
    }
    return $page_url.$concate;
}
?>