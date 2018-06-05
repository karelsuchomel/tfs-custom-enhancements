<?php

/* Arrange WP Editor Toolbar Buttons */
add_filter( 'mce_buttons', 'my_wpeditor_buttons', 10, 2 );
 
/**
 * Add Buttons To WP Editor Toolbar.
 */
function my_wpeditor_buttons( $buttons, $editor_id ){
	/* if not "content" editor, bail */
	if ( 'content' != $editor_id ){
			return $buttons;
	}
	/* Add it as first item in the row */
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add Dropcap option but keep the defaults.
 */
function tfs_wpeditor_formats_options( $settings ){
 
 
		/* Our Own Custom Options */
		$custom_style_formats = array(
				array(
						'title'   => 'Anchor',
						'inline'  => 'a',
						'classes' => 'text-anchor',
				),
		);
 
		/* Add it in tinymce config as json data */
		$settings['style_formats'] = json_encode( $custom_style_formats );
		return $settings;
}

/* Filter */
add_filter( 'tiny_mce_before_init', 'tfs_wpeditor_formats_options' );