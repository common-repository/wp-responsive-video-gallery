<?php
	/*
	Plugin Name: Wp Responsive Video Gallery
	Plugin URI: http://pluginspoint.com/videogallery/
	Description: Responsive Video Gallery is a very effective WordPress video gallery plugin which allows you to make nice looking video galleries with responsive layouts and customizable styles.
	Version: 1.0
	Author: Pluginspoint
	Author URI: http://www.pluginspoint.com
	TextDomain: wpsvgallery
	License: GPLv2
	*/

	if( !defined( 'ABSPATH' ) ){
	    exit;
	}

	define('WPSVG_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	define('wpsvg_plugin_dir', plugin_dir_path(__FILE__) );

	function wpsvgallery_load_init(){

    wp_enqueue_style( 'wpsvgallery-app-css', WPSVG_PLUGIN_PATH.'assets/css/svvg-styles.css' );

    wp_enqueue_script( 'jquery' );
/*     wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script("jquery-ui-droppable"); */

	wp_enqueue_script( 'wpsvgallery_colorpicker_js', plugins_url( '/assets/js/jscolor.js' , __FILE__ ) , array( 'jquery' ) );
    wp_enqueue_script( 'wpsvgallery_speedvault_js', plugins_url( '/assets/js/speedvault.js' , __FILE__ ) , array( 'jquery' ) );
    wp_enqueue_script( 'wpsvgallery_wpsvgallery_js', plugins_url( '/assets/js/wpsvgallery.js' , __FILE__ ) , array( 'jquery' ) );
	}
	add_action( 'init', 'wpsvgallery_load_init' );
	
	function wpsvgallery_load_admin(){
		//wpsvgallery admin
		wp_enqueue_style( 'wpsvgallery_admin', WPSVG_PLUGIN_PATH.'assets/admin/wpsvgallery_admin.css' );	
		wp_enqueue_style( 'wpsvgallery_alert', WPSVG_PLUGIN_PATH.'assets/admin/iao-alert.css' );
		wp_enqueue_script( 'wpsvgallery_alert_js', plugins_url( '/assets/admin/iao-alert.jquery.js' , __FILE__ ) , array( 'jquery' ) );
	}
	add_action( 'admin_enqueue_scripts', 'wpsvgallery_load_admin' );	


	# Load plugin Translations
	function wpsvgallery_load_textdomain(){

		load_plugin_textdomain('wpsvgallery', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );

	}
	add_action('plugins_loaded', 'wpsvgallery_load_textdomain');

	# Post Type
	require_once( 'lib/post-type/wpsvgallery-post-type.php' );

	# Metabox
	require_once( 'lib/metabox/wpsvgallery-metabox.php' );

	#Shortcode
	require_once( 'lib/shortcode/wpsvgallery-shortcode.php' );

?>