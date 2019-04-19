{{--
  Template Name: Login Template
--}}

@extends('layouts.sign')

<meta name="google-signin-client_id" content="919394023436-6ouc3661lhv6u4ea3hntkkhgsguvmj16.apps.googleusercontent.com">

<?php 

if($_POST) 
{ 
    $success = '';
    $error = '';
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
        echo '<span class="mine">Invlaid Login Details</span>'; 
    } else { 
        echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>"; 
    exit(); 
    } 

} else {  

}

?>

<div class="logo">
	<a href="/">
		<img src="@asset('images/logo-big.png')">
	</a>
</div>

<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->
<form class="splash-container" method="post">
    <div class="card bg-transparent border-0 shadow-none mb-3">
        <div class="card-header">
            <h3 class="form-title">Login to your account</h3>
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
            <a class="small" href="#" onclick="signOut();">Sign out</a>
            <div class="login-txt">
                <p class="forgot-psw mb-1">Forgot your password ?</p>
                <p class="smaller-txt">no worries, click <a href="{{ home_url() }}">here</a> to reset your password.</p>
            </div>
            <div class="login-txt create-account">
                <p class="smaller-txt">Don't have an account yet ?  Register a new membership <a href="/register/'">Create an account</a> </p>
            </div>                         
        </div>
    </div>
</form>

<script>
    function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 175,
        'height': 40,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }

function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://yourbackend.example.com/tokensignin');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);
}



</script>

<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
