<?php

// exit if accessed directly
if ( ! defined( 'ABSPATH' ))
{
	exit;
}

function gl_register_post_type ()
{
	$singular = 'galerie';
	$plural = 'Galerie';

	$labels = array(
		'name' => $plural,
		'singular_name'				=> $singular,
		'add_name'						=> 'Přidat',
		'add_new_item'				=> 'Přidat ' . $singular,
		'edit'								=> 'Upravit',
		'edit_item'						=> 'Upravit ' . $singular,
		'new_item'						=> 'Nová ' . $singular,
		'view'								=> 'Zobrazit ' . $singular,
		'view_item'						=> 'Zobrazit ' . $singular,
		'saerch_item'					=> 'Hledat ' . $singular,
		'not_found'						=> 'Žádné ' . $plural . ' nebyly nenalezeny',
		'not_found_in_trash'	=> 'Žádné ' . $plural . ' nebyly v koši  nenalezeny'
		);

	$args = array(
		'labels'							=> $labels,
		'public'							=> true,
		'exclude_from_search'	=> false,
		'show_in_nav_menus' 	=> false,
		'show_in_admin_bar' 	=> false,
		'label'								=> 'Galerie',
		'menu_position'				=> 6,
		'menu_icon'						=> 'dashicons-images-alt',
		'can_export'					=> true,
		'delete_with_user'		=> false,
		'hirrarchical'				=> false,
		'has_archive'					=> false,
		'query_var'						=> true,
		'capability_type'			=> 'post',
		'map_meta_cap' => true,

		'rewrite' => array(
			'slug' => 'galerie',
			'feeds' => false,
			),

		'supports' => array(
			'title'
			)
		);

	register_post_type( 'gallery', $args );
}
add_action( 'init', 'gl_register_post_type' );

?>