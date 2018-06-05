<?php
/**
* Plugin Name: Tools For Schools - custom enhancements
* Description: Customize Admin UI, adds field to set a important date for post (that will be shown in agenda)
* Authro: Karel Suchomel
* Version: 0.2
* License: MIT
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// enqueue styles and scripts
function tfs_admin_enqueue_scripts()
{
	// $pagenow = post-new.php | post.php
	// $typenow = "current post type..like post ot jobs or something"
	global $pagenow, $typenow;
	
	if ( ($pagenow === 'post.php' || $pagenow === 'post-new.php') && $typenow === 'post' )
	{
		wp_enqueue_style( 'tfs-admin-css', plugins_url( 'css/admin-tfs.css', __FILE__ ) );
		wp_enqueue_script( 'tfs-admin-js', plugins_url( 'js/admin-tfs.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '27102017', true );
		// Google style for jQuery datepicker
		wp_enqueue_style( 'jquery-style', plugins_url( 'css/google-jquery-theme.css', __FILE__ ) );
	}
}
add_action( 'admin_enqueue_scripts', 'tfs_admin_enqueue_scripts' );

// edit formating toolbar of TiniMCE editor
require_once( plugin_dir_path(__FILE__) . 'tinimce-toolbar-settings.php');

// remove all metaboxes from dashboard page and remove unused menu items
require_once( plugin_dir_path(__FILE__) . 'filter-wordpress-ui.php');

// register custom tag: "has-gallery" for posts that includes gallery
// require_once( plugin_dir_path(__FILE__) . 'taxonomy-tfs-meta-tags.php');

// add custom metaboxes () for posts
require_once( plugin_dir_path(__FILE__) . 'post-metaboxes/posts-fields.php');

// run after plugin installation
