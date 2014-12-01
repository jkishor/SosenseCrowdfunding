<?php

/**
Plugin Name: Sosense Crowdfunding
Plugin URL: http://sosense.org
Description: Sosense Sales Stats Widget
Version: 1.1
Author: Sosense
Author URI: http://www.sosense.org
**/

include_once dirname( __FILE__ ) . '/function.php';
include_once dirname( __FILE__ ) . '/crowdfunding_details.php';

add_action( 'init', 'payments_init' );
add_action( 'widgets_init', 'child_marketify_edd_widgets_init' );
add_action( 'after_setup_theme', 'my_child_theme_setup' );
add_action( 'wp_enqueue_scripts', 'sosense_funding' );
add_action( 'wp_enqueue_scripts', 'eddstat_scripts' );
add_action( 'init', 'payments_init_2' );
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
add_action( 'add_meta_boxes', 'Sales_Goal_add' );
add_action( 'save_post', 'cd_meta_box_save' );
add_action( 'save_post', 'Sales_Goal_save' );
add_action( 'wp_enqueue_scripts', 'campaigning_scripts' );
add_action( 'wp_enqueue_scripts', 'campaigning_css' );
	
	
?>
