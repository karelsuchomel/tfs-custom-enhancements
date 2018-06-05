<?php
function tfs_register_taxonomy()
{

	$labels = array(
		'name'              => _x( 'TFS Meta Tags', 'taxonomy general name', 'tfs-textdomain' ),
		'singular_name'     => _x( 'TFS Meta Tag', 'taxonomy singular name', 'tfs-textdomain' ),
		'search_items'      => __( 'Search Tags', 'tfs-textdomain' ),
		'all_items'         => __( 'All Tags', 'tfs-textdomain' ),
		'parent_item'       => __( 'Parent Tag', 'tfs-textdomain' ),
		'parent_item_colon' => __( 'Parent Tag:', 'tfs-textdomain' ),
		'edit_item'         => __( 'Edit Tag', 'tfs-textdomain' ),
		'update_item'       => __( 'Update Tag', 'tfs-textdomain' ),
		'add_new_item'      => __( 'Add New Tag', 'tfs-textdomain' ),
		'new_item_name'     => __( 'New Tag Name', 'tfs-textdomain' ),
		'menu_name'         => __( 'TFS Meta Tag', 'tfs-textdomain' ),
	);

	$args = array(
		'public'								=> false,
		'hierarchical'					=> false,
		'labels'								=> $labels,
		'update_count_callback'	=> '_update_post_term_count',
		'query_var'							=> true,
		'rewrite'								=> false
	);

	register_taxonomy( 'tfs_meta_tags', 'post', $args );
	register_taxonomy_for_object_type( 'tfs_meta_tags', 'post' );
}

add_action( 'init', 'tfs_register_taxonomy');