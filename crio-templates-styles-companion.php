<?php
/*
Plugin Name: Crio Templates and Styles Companion
Description: Crio companion plugin to override templates and enque larger style sheets
Author: W3ap0n-X
Version: 0.1.0
*/

/*
* Main Plugin URL
* Note that there is no trailing slash
*/
define('CTSC_PATH', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/*
* Main Plugin Dir
* Note that there is no trailing slash
*/
define('CTSC_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

/*
* Debug mode
* Change value below to 'true' to output debug dumps
*/
define('CTSC_DEBUG', false);

/*
* Readable debug dump
*/
function ctsc_debug_dump($var, $label = null){
    echo $label . '<pre>' . print_r($var, true) . '</pre>';
}

/* #################### CSS Stylesheets #################### */

/*
* Stylesheet List
* Array of CSS files to enqueue
* add new css file to '/css/' directory, to activate the css file add the file name to the list below (do not include .css extension)
*/
$ctsc_custom_styles = array(
    'my_styles' , 
);
define('CTSC_STYLES', $ctsc_custom_styles);

/*
* Enqueue Custom stylesheets
*/
function ctsc_enqueue_custom_styles() {
    
    $plugin_path  = CTSC_PATH . '/css/';
    if(CTSC_DEBUG){ctsc_debug_dump($plugin_path, "Custom Style Path");}
    if(CTSC_DEBUG){ctsc_debug_dump(CTSC_STYLES, 'Custom Style List');}
    foreach(CTSC_STYLES as $custom_style){
        if(CTSC_DEBUG){ctsc_debug_dump($custom_style, "Custom Style");}
        wp_enqueue_style( 'ctsc_' . $custom_style , $plugin_path . $custom_style . '.css');
    }
}
add_action( 'wp_enqueue_scripts', 'ctsc_enqueue_custom_styles');

/* #################### JS Scripts #################### */

/*
* JS Script List
* Array of JS files to enqueue
* add new css file to '/js/' directory, to activate the css file add the file name to the list below (do not include .js extension)
*/
$ctsc_custom_scripts = array(
    'my_scripts' , 
);
define('CTSC_SCRIPTS', $ctsc_custom_scripts);

/*
* Enqueue Custom JS Scripts
*/
function ctsc_enqueue_custom_scripts() {
    
    $plugin_path  = CTSC_PATH . '/js/';
    if(CTSC_DEBUG){ctsc_debug_dump($plugin_path, "Custom Scripts Path");}
    if(CTSC_DEBUG){ctsc_debug_dump(CTSC_SCRIPTS, 'Custom Scripts List');}
    foreach(CTSC_SCRIPTS as $custom_script){
        if(CTSC_DEBUG){ctsc_debug_dump($custom_script, "Custom Script");}
        wp_enqueue_script( 'ctsc_' . $custom_script , $plugin_path . $custom_script . '.js');
    }
}
add_action( 'wp_enqueue_scripts', 'ctsc_enqueue_custom_scripts');

/* #################### Custom Templates #################### */

/*
* CTSC_TEMPLATE_PATH
* Path to custom templates from this plugin
*/
define('CTSC_TEMPLATE_PATH', CTSC_DIR  . '/templates/');

/*
* Load Custom Crio Template Override
* Is automatic, to override existing templates just copy and add your own to '/templates/' directory
*/
function ctsc_crio_custom_template($_template){
    $theme_path = get_theme_file_path( ) . '/';
    $template_name = str_replace($theme_path, '' , $_template );
    $plugin_path  = CTSC_TEMPLATE_PATH;
    if( file_exists( $plugin_path . $template_name ) ){
        $template = $plugin_path . $template_name;
    } else {
        $template = $_template;
    }
    if(CTSC_DEBUG){
        ctsc_debug_dump($template, 'Loaded Template');
    }
    return $template;
}

// Filter for Crio Template replacement
add_filter('template_include' , 'ctsc_crio_custom_template' );


/*
* Look for Custom WooCommerce Template Overrides
* Is automatic, to override existing templates just copy and add your own to '/templates/woocommerce/' directory
*/
function ctsc_woo_custom_template( $template, $template_name, $template_path ) {
    global $woocommerce;
    $_template = $template;
    if ( ! $template_path ) {
        $template_path = $woocommerce->template_url;
    }
    $plugin_path  = CTSC_TEMPLATE_PATH . '/woocommerce/';
    $template = locate_template(
        array(
            $template_path . $template_name,
            $template_name
        )
    );
    if( ! $template && file_exists( $plugin_path . $template_name ) ){
        $template = $plugin_path . $template_name;
    }
    if ( ! $template ) {
        $template = $_template;
    }
    if(CTSC_DEBUG){
        ctsc_debug_dump($template, 'Loaded Woocommerce Template' );
    }
    return $template;
}

// Filter for WooCommerce Template replacement
add_filter( 'woocommerce_locate_template', 'ctsc_woo_custom_template', 1, 3 );

/* #################### Custom Functions #################### */

/*
* Provided a functions.php file to align with child theme conventions
*/
require_once(CTSC_DIR . '/functions.php');
