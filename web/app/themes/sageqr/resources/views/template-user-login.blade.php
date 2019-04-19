{{--
  Template Name: Login Template
--}}

@extends('layouts.sign')

<!-- <meta name="google-signin-client_id" content="919394023436-6ouc3661lhv6u4ea3hntkkhgsguvmj16.apps.googleusercontent.com"> -->
<meta name="google-signin-client_id" content="919394023436-4l8og8t1c21d73incig318914d64f51v.apps.googleusercontent.com">

<style type="text/css">
    .for_button {
        color: #ccc;
        cursor: pointer;
        padding:5px;
        text-align:center;
        border:1px solid green;
        border-radius:5px;
        width:150px;
    }
</style>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://apis.google.com/js/api.js" async defer></script>

<?php
$client_id = '919394023436-4l8og8t1c21d73incig318914d64f51v.apps.googleusercontent.com'; // Client ID
$client_secret = 'evcWY2gbPg8pg6LcBSLVOSRJ'; // Client secret
// $redirect_uri = 'http://http://test5.local'; // Redirect URI
//$redirect_uri = 'https://www.nemkorrektur.dk/register'; // Redirect URI
$redirect_uri = 'https://www.nemkorrektur.dk/'; // Redirect URI
//$redirect_uri = 'https://www.nemkorrektur.dk/homepage'; // Redirect URI


$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);


echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';
// https://accounts.google.com/o/oauth2/auth?redirect_uri=http://localhost/google-auth&response_type=code&client_id=333937315318-fhpi4i6cp36vp43b7tvipaha7qb48j3r.apps.googleusercontent.com&scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile


if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $url = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];

        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }
}
    // if ($result) {
        // echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
        // echo "Имя пользователя: " . $userInfo['name'] . '<br />';
        // echo "Email: " . $userInfo['email'] . '<br />';
        // echo "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />';
        // echo "Пол пользователя: " . $userInfo['gender'] . '<br />';
        // echo '<img src="' . $userInfo['picture'] . '" />'; echo "<br />";
    // }    




// $button = "Button";


// if($_POST['param']) {
//  $param = json_decode($_POST['param']);
//  $row = get_text($param->id);
//  echo json_encode($row);
//  exit();
// }




// $fn  = $_POST['fn'];
// $str = $_POST['str'];
// $file = fopen($fn . ".record","w");
// echo fwrite($file, $str);
// fclose($file);


if (isset($_GET['u_name']))
{
    echo "Значение JavaScript-переменной: ". $_GET['u_name'];
}

else
{
    echo '<script>';
    // echo 'document.location.href="' . $_SERVER['REQUEST_URI'] . '?u_name=" + userName2';
    // echo 'document.location.href="http://test5.local/login/' . '?u_name=" + email';
    echo '</script>';
    // exit();
}


?>

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

<div class="btn-wrap"></div>

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
    // var button = "<?php //echo $button; ?>";
    // alert("button");
    // jQuery(".btn-wrap").prepend("<p class='for_button'>" + button + "</p>");

</script>


<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
<!-- <script src="https://apis.google.com/js/api.js" async defer></script> -->


<script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
      }
    </script>



<script>
    function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        // alert("hello");
        onSignIn(googleUser);
        window.onLoadCallback = function(){
            if (auth2.isSignedIn.get()) {
              var profile = auth2.currentUser.get().getBasicProfile();
              console.log('ID: ' + profile.getId());
              console.log('Full Name: ' + profile.getName());
              console.log('Given Name: ' + profile.getGivenName());
              console.log('Family Name: ' + profile.getFamilyName());
              console.log('Image URL: ' + profile.getImageUrl());
              console.log('Email: ' + profile.getEmail());
            }
        }
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

function onSignIn2(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://test5.local/tokensignin');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);


    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

}
</script>

<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>

<script>

</script>