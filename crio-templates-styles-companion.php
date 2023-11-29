<?php
/*
Plugin Name: Crio Templates and Styles Companion
Description: Crio companion plugin to override templates and enque larger style sheets
Author: W3ap0n-X
Version: 0.0.1
*/

/*
* Debug mode
* Change value below to 'true' to output debug dumps
*/
define('CTSC_DEBUG', false);

/*
* Readable debug dump
*/
function ctsc_debug_dump($var){
    echo '<pre>' . print_r($var, true) . '</pre>';
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
    
    $plugin_path  = untrailingslashit( plugin_dir_url( __FILE__ ) )  . '/css/';
    if(CTSC_DEBUG){ctsc_debug_dump($plugin_path);}
    if(CTSC_DEBUG){ctsc_debug_dump(CTSC_STYLES);}
    foreach(CTSC_STYLES as $custom_style){
        if(CTSC_DEBUG){ctsc_debug_dump($custom_style);}
        wp_enqueue_style( 'ctsc_' . $custom_style , $plugin_path . $custom_style . '.css');
    }
}
add_action( 'wp_enqueue_scripts', 'ctsc_enqueue_custom_styles');

/* #################### Custom Templates #################### */

/*
* CTSC_TEMPLATE_PATH
* Path to custom templates from this plugin
*/
define('CTSC_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/templates/');

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
        ctsc_debug_dump($template );
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
    if(CTSC_DEBUG){
        ctsc_debug_dump($template_path . $template_name );
    }
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
    return $template;
}

// Filter for WooCommerce Template replacement
add_filter( 'woocommerce_locate_template', 'ctsc_woo_custom_template', 1, 3 );
