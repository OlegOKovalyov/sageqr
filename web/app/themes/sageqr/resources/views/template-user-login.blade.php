{{--
  Template Name: Login Template
--}}

@extends('layouts.sign')

@section('content')
  {{--@while(have_posts())
    {!! the_post() !!}
    @include('partials/content-single')
  @endwhile --}}


<?php 
// Sign In to the site with E-mail and Password
// if ( is_user_logged_in() ) {
//     wp_redirect( site_url('/') );
//     exit;
// }

$success = '';
$error = '';

if($_POST) 
{ 
    global $wpdb; 

    //We shall SQL esc_like all inputs 
    $username = $wpdb->esc_like($_REQUEST['email']); 
    $password = $wpdb->esc_like($_REQUEST['password']); 
    // $remember = $wpdb->esc_like($_REQUEST['rememberme']); 

    // if($remember) $remember = "true"; 
    // else $remember = "false"; 

    $login_data = array(); 
    $login_data['user_login'] = $username; 
    $login_data['user_password'] = $password; 
    // $login_data['remember'] = $remember; 

    $user_verify = wp_signon( $login_data, false ); 

    if ( is_wp_error($user_verify) ) 
    { 
        // echo '<span class="mine">Invlaid Login Details</span>';
        $error = 'Invlaid Login Details.';

    } else { 
        $success = 'You are successfully logged in!';
        echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>"; 
    exit(); 
    } 

    } else {  

    }

?>


<?php
// Sign In with Google to the site
global $wpdb, $PasswordHash, $current_user, $user_ID;

//Step 1: Enter you google account credentials
$g_client = new Google_Client();
$g_client->setClientId("919394023436-is2qbur2uetd0eobultdhi4bvd3h4roq.apps.googleusercontent.com");
$g_client->setClientSecret("mE7LIQKGFzAgps-JxMjuwD3z");
// $g_client->setRedirectUri("https://testok2.dev-test.pro/login");
$g_client->setRedirectUri("https://test5.local/login");
// $g_client->setRedirectUri("https://www.nemkorrektur.dk/login");
$g_client->setIncludeGrantedScopes(true);

$g_client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
$output = "<a href='$auth_url'><img src='/app/themes/sageqr/dist/images/btn_google_signin_light_normal_web.png' alt=''/></a>";

//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;


//Step 4: Get access token
if(isset($code)) {
    try {
        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);
    }catch (Exception $e){
        echo $e->getMessage();
    }
    try {
        $pay_load = $g_client->verifyIdToken();
    }catch (Exception $e) {
        echo $e->getMessage();
    }
} else{
    $pay_load = null;
}

if(isset($pay_load)){

    $guser_email = $pay_load["email"];
    $guser_gn = $pay_load["given_name"];
    $guser_fn = $pay_load["family_name"];

    $glogin_data = array(); 
    $glogin_data['user_login'] = $guser_email; 
    $glogin_data['user_password'] = 'eYkEVu7zyHR7pT4G';

    if ( is_user_logged_in() ) {
        echo 'Вы авторизованы на сайте!';
    }
    else {

        if ( email_exists($guser_email) ) {

            $guser_verify = wp_signon( $glogin_data, false ); 

            if ( is_wp_error($guser_verify) ) 
            { 
                echo '<span class="mine">Invlaid Login Details</span>'; 
            } else { 
                echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>"; 
                exit(); 
            } 
        }

        else {

            $guser_data = array(
                'ID'              => 0,  // когда нужно обновить пользователя 0
                'user_pass'       => 'eYkEVu7zyHR7pT4G', // обязательно
                'user_login'      => $guser_email, // обязательно
                'user_nicename'   => '',
                'user_url'        => '',
                'user_email'      => $guser_email,
                'display_name'    => '',
                'nickname'        => '',
                'first_name'      => $guser_gn,
                'last_name'       => $guser_fn,
                'description'     => '',
                'rich_editing'    => 'true', // false - выключить визуальный редактор
                'user_registered' => '', // дата регистрации (Y-m-d H:i:s) в GMT
                'role'            => 'subscriber', // (строка) роль пользователя
                'jabber'          => '',
                'aim'             => '',
                'yim'             => '',
            );

            wp_insert_user( $guser_data );

            $guser_verify = wp_signon( $glogin_data, false ); 

            if ( is_wp_error($guser_verify) ) 
            { 
                echo '<span class="mine">Invlaid Login Details</span>'; 
            } else { 
                echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>"; 
                exit(); 
            } 
        }
     
    }    

}
?>

<div class="btn-wrap"></div>

<div class="logo">
	<a href="/">
		<img src="@asset('images/logo-big.png')">
	</a>
</div>

<!-- ============================================================== -->
<!-- signin form  -->
<!-- ============================================================== -->
<form class="splash-container" method="post">
    <div class="card bg-transparent border-0 shadow-none mb-3">
        <div class="card-header">
            <h3 class="form-title">Login to your account</h3>
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
            		<i class="fa fa-user"></i>
                	<input class="form-control form-control-lg" type="email" name="email" required="" placeholder="E-mail" autocomplete="off">
            	</div>
            </div>
            <div class="form-group">
            	<div class="input-icon">
            		<i class="fa fa-lock"></i>
                	<input class="form-control form-control-lg" id="pass1" type="password" name="password" required="" placeholder="Password">
            	</div>
            </div>
            <div class="form-group form-actions alignright">
            	<button id="register-back-btn" class="btn-primary" login-url="<?php home_url() ?>" type="submit"><i class="far fa-arrow-alt-circle-right"></i> Login</button>
            	<input type="hidden" name="task" value="login" />
            </div>
            <div class="login-txt">
                <p>Or login with</p>
            </div>
            <div id="my-signin2"></div>
            <div class="form-group">
                <!-- Display login button / Google profile information -->
                <?php echo $output; ?>
            </div>
            <div class="login-txt">
                <p class="forgot-psw mb-1">Forgot your password ?</p>
                <p class="smaller-txt">no worries, click <a href="{{ home_url('/lost-password/') }}">here</a> to reset your password.</p>
            </div>
            <div class="login-txt create-account">
                <p class="smaller-txt">Don't have an account yet ?  Register a new membership <a href="/register/'">Create an account</a> </p>
            </div>                         
        </div>
    </div>
</form>
<!-- ============================================================== -->
<!-- signin form  -->
<!-- ============================================================== -->
@endsection