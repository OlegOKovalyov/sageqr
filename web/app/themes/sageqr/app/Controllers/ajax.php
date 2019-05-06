<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;


/**
 * Ajax Handler
 */
add_action('wp_ajax_hello', 'say_hello', 99);
add_action('wp_ajax_nopriv_hello', 'say_hello', 99);
function say_hello() {
    $name = empty( $_GET['name'] ) 
    ? 'user' 
    : esc_attr( $_GET['name'] );
    echo "Hello, $name!";
    wp_die();
}