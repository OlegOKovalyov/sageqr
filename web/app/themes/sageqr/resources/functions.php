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
    wp_enqueue_script ("my-ajax-handle", get_stylesheet_directory_uri() . "/assets/scripts/myajax.js", array('jquery')); 
    //the_ajax_script will use to print admin-ajaxurl in custom ajax.js
    wp_localize_script('my-ajax-handle', 'the_ajax_script',
        array(
            'myajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('myajax-nonce'),
        ));
}
add_action("wp_enqueue_scripts", "js_enqueue_scripts");


add_action( 'wp_ajax_nopriv_myajax-remove', 'myajax_remove' );
add_action( 'wp_ajax_myajax-remove', 'myajax_remove' );
function myajax_remove(){
    $path = $_POST['path'];
    echo $path . '<br>';
    $fileName = $_POST['fileName'];
    echo $fileName . '<br>';
    $currentUser = $_POST['currentUser'];
    echo $currentUser . '<br>';
    var_dump(getcwd()); echo '<br>';
    
    // var_dump( getcwd() . '../../app/themes/sageqr/resources/UserDir/' . $currentUser . '/' . $fileName ); echo '<br>';
    // var_dump( get_theme_root() . '/sageqr/resources/UserDir/' . $currentUser . '/' . $fileName );
    var_dump( get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/' . $fileName );
    echo '<br>';
    // die;
    // проверяем nonce код, если проверка не пройдена прерываем обработку

    // echo 'test';
    check_ajax_referer( 'myajax-nonce', 'nonce_code' );

    // текущий пользователь не имеет права автора или выше
    // if( ! current_user_can('subscriber') ) 
    //     die('Этот запрос доступен пользователям с правом автора или выше.');

    // ОК. У юзера есть нужные права!
    // $path = $_POST['path'];
    // echo $path . '<br>'; 
    $return_text = 0;
    // $abs_path =  getcwd() . '/../../app/themes/sageqr/resources/UserDir/' . $currentUser . '/' . $fileName;
    // $abs_path =  get_theme_root() . 'sageqr/resources/UserDir/' . $currentUser . '/' . $fileName;
    $abs_path =  get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/' . $fileName;

// unlink($abs_path);
    // Check file exist or not
    if( file_exists($abs_path) ){

      // Remove file 
      // unlink($path);
      unlink($abs_path);
      // wp_delete_file( $abs_path );


      // Set status
      $return_text = 1;

    } else {

      // Set status
      $return_text = 0;
    }

    // Return status
    echo $return_text;
    // Делаем что нужно и выводим данные на экран, чтобы вернуть их скрипту
exit;
    // Не забываем выходить
    wp_die();
}


add_action( 'wp_ajax_nopriv_myajax-rename', 'myajax_rename' );
add_action( 'wp_ajax_myajax-rename', 'myajax_rename' );
function myajax_rename(){
    $path = $_POST['path'];
    echo $path . '<br>';
    $fileName = $_POST['fileName'];
    echo $fileName . '<br>';
    $newFileName = $_POST['newFileName'];
    echo $newFileName . '<br>';    
    $currentUser = $_POST['currentUser'];
    echo $currentUser . '<br>';
    var_dump(getcwd()); echo '<br>';

    var_dump( get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/' . $fileName );
    echo '<br>';
    // die;
    // проверяем nonce код, если проверка не пройдена прерываем обработку

    check_ajax_referer( 'myajax-nonce', 'nonce_code' );

    // текущий пользователь не имеет права автора или выше
    // if( ! current_user_can('subscriber') ) 
    //     die('Этот запрос доступен пользователям с правом автора или выше.');

    // ОК. У юзера есть нужные права!

    $return_text = 0;

    $abs_path_old =  get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/' . $fileName;
    echo $abs_path_old;
    $abs_path_new =  get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/' . $newFileName;
    echo $abs_path_new;

    // Check file exist or not
    if( file_exists($abs_path_old) && ! file_exists($abs_path_new) ){

      // Remove file 
      // unlink($abs_path);
      rename($abs_path_old, $abs_path_new);

      // Set status
      $return_text = 1;

    } else {

      // Set status
      $return_text = 0;
    }

    // Return status
    echo $return_text;
    // Делаем что нужно и выводим данные на экран, чтобы вернуть их скрипту
//exit;
    // Не забываем выходить
    wp_die();
}


add_action( 'wp_ajax_nopriv_myajax-updaterev', 'myajax_updaterev' );
add_action( 'wp_ajax_myajax-updaterev', 'myajax_updaterev' );
function myajax_updaterev(){

    $user_ID = $_POST['user_id']; echo $user_ID;
    $usr_upload_dir = $_POST['usr_upload_dir']; echo $usr_upload_dir;
    var_dump($_POST['my_file_upload']);
    
    check_ajax_referer( 'myajax-nonce', 'nonce_code' );

    /*if( isset( $_POST['my_file_upload'] ) ) {  
        // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

        //$uploaddir = './uploads'; // . - текущая папка где находится submit.php
        $uploaddir = get_theme_root() . '/sageqr/UserDir/' . $currentUser . '/'; 

        // cоздадим папку если её нет
        if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

        $files      = $_FILES; // полученные файлы
        $done_files = array();

        // переместим файлы из временной директории в указанную
        foreach( $files as $file ){
            $file_name = $file['name'];

            if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
                $done_files[] = realpath( "$uploaddir/$file_name" );
            }
        }

        $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

        die( json_encode( $data ) );
    }*/
}