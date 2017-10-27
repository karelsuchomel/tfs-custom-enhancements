<?php
// remove all metaboxes from dashboard page
function tfs_customize_dashboard_widgets()
{
	// which metabox, on what page is it on, in which section is it located
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );				// Right Now
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );	// Recent Comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );		// Incoming Links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );					// Plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );				// Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );			// Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );						// WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );					// Other WordPress News
}
add_action( 'wp_dashboard_setup', 'tfs_customize_dashboard_widgets' );

// remove unused menu items
function my_remove_menu_pages()
{
	remove_menu_page( 'edit-comments.php' );			//Comments
}
add_action( 'admin_menu', 'my_remove_menu_pages' );