<?php

function lm_add_custom_metabox ()
{
	add_meta_box(
		'lm-monday-lunch',
		'Pondělí',
		'lm_meta_callback',
		'lunch-menu'
	);
}
add_action( 'add_meta_boxes', 'lm_add_custom_metabox' );

?>