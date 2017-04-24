<?php

// exit if accessed directly
if ( ! defined( 'ABSPATH' ))
{
	exit;
}

function lm_register_post_type ()
{
	$singular = 'jídelníček';
	$plural = 'Jídelníčky';

	$labels = array(
		'name' => $plural,
		'singular_name'				=> $singular,
		'add_name'						=> 'Přidat',
		'add_new_item'				=> 'Přidat ' . $singular,
		'edit'								=> 'Upravit',
		'edit_item'						=> 'Upravit ' . $singular,
		'new_item'						=> 'Nový ' . $singular,
		'view'								=> 'Zobrazit ' . $singular,
		'view_item'						=> 'Zobrazit ' . $singular,
		'saerch_item'					=> 'Hledat ' . $singular,
		'not_found'						=> 'Žádné ' . $plural . ' nenalezeny',
		'not_found_in_trash'	=> 'Žádné ' . $plural . ' nebyly v koši  nenalezeny'
		);

	$args = array(
		'labels'							=> $labels,
		'public'							=> true,
		'exclude_from_search'	=> true,
		'show_in_nav_menus' 	=> false,
		'show_in_admin_bar' 	=> false,
		'label'								=> 'Jídelníčky',
		'menu_position'				=> 20,
		'menu_icon'						=> 'dashicons-carrot',
		'can_export'					=> true,
		'delete_with_user'		=> false,
		'hirrarchical'				=> false,
		'has_archive'					=> false,
		'query_var'						=> true,
		'capability_type'			=> 'post',
		'map_meta_cap' => true,

		'rewrite' => array(
			'slug' => 'jidelnicky',
			'feeds' => false,
			),

		'supports' => array(
			'title'
			)
		);

	register_post_type( 'lunch-menu', $args );
}
add_action( 'init', 'lm_register_post_type' );

?>