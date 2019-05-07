<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);


/**
 * My AJAX Functions
 */
function js_enqueue_scripts() {
    wp_enqueue_script ("my-ajax-handle", get_stylesheet_directory_uri() . "/assets/scripts/ajax-remove.js", array('jquery')); 
    //the_ajax_script will use to print admin-ajaxurl in custom ajax.js
    wp_localize_script('my-ajax-handle', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
} 
add_action("wp_enqueue_scripts", "js_enqueue_scripts");

function more_post_ajax() {
  
    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 1;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
  
    header("Content-Type: text/html");
  
    $args = array(
        'suppress_filters' => true,
        'post_type' => 'post',
        'posts_per_page' => $ppp,
        'paged' => $page,
    );
  
    $loop = new WP_Query($args);
  
    $out = '';
  
    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
            $out .= '
            <div class="small-12 large-4 columns"><h1>' . get_the_title() . '</h1>' . get_the_content() . '</div>';
        endwhile;
    endif;
    wp_reset_postdata();
    die($out);
}
  
add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');




// function js_enqueue_scripts() {
//     wp_enqueue_script ("rm-ajax-handle", get_stylesheet_directory_uri() . "/assets/scripts/ajax-remove.js", array('jquery')); 
//     //the_ajax_script will use to print admin-ajaxurl in custom ajax.js
//     wp_localize_script('rm-ajax-handle', 'rm_ajax_script', array('ajaxurl' =>admin_url('admin-ajax.php')));
// } 
// add_action("wp_enqueue_scripts", "js_rm_enqueue_scripts");

function file_remove_ajax() {

    global $user_ID; echo $user_ID;

    global $post;
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;

    $usr_upload_dir = get_template_directory() . '/UserDir/' . $current_user_id;



    $filename = 'full absolute file path';
    if(file_exists($filename)) {
        @chmod($filename, 0777);
        @unlink($filename);
        return true;
    }

  
    // $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 1;
    // $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
  
    // header("Content-Type: text/html");
  
    // $args = array(
    //     'suppress_filters' => true,
    //     'post_type' => 'post',
    //     'posts_per_page' => $ppp,
    //     'paged' => $page,
    // );
  
    // $loop = new WP_Query($args);
  
    // $out = '';
  
    // if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
    //         $out .= '
    //         <div class="small-12 large-4 columns"><h1>' . get_the_title() . '</h1>' . get_the_content() . '</div>';
    //     endwhile;
    // endif;
    // wp_reset_postdata();
    // die($out);
}
  
add_action('wp_ajax_nopriv_more_post_ajax', 'file_remove_ajax');
add_action('wp_ajax_more_post_ajax', 'file_remove_ajax');