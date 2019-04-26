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

    public static function GenPassword($length = 8) {

		$password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$maxlength = strlen($possible);

		if ($length > $maxlength) {

		    $length = $maxlength;
		}

		$i = 0; 

		while ($i < $length) { 

			$char = substr($possible, mt_rand(0, $maxlength-1), 1);

			if (!strstr($password, $char)) { 

				$password .= $char;

			$i++;

			}
		}

		return $password;
	}  





}
