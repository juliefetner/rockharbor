<?php 



// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
 
    $path = __DIR__ . '/acf/';
    
    return $path;
    
}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_bloginfo('template_directory') . '/libs/acf/';
    
    // return
    return $dir;
    
}

// // 3. Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');

// // 4. Include ACF
include_once( __DIR__ . '/acf/acf.php' );



add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    
    $path = __DIR__ . '/custom-fields';
    
    return $path;

}


add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    
    unset($paths[0]);
    
    $paths[] = __DIR__ . '/custom-fields';
    
    return $paths;
    
}
