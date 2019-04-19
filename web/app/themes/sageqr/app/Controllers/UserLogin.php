<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class UserLogin extends Controller
{
	public static function loginForm() {
    // return $something; // get_the_title();
    return wp_login_form( ['redirect' => home_url()] );
  	}

  	public function siteName() {
        return get_bloginfo('name');
    }
}
