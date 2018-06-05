<?php
// handle custom post meta based on the content
// now only saves the meta values generated with parsing functions
function handlePostMetaBasedOnContent($metaBasedOnContent, $post_id)
{
	foreach ($metaBasedOnContent as $key => $value) 
	{
		// echo "<hr>";
		// echo "<hr>";
		// echo "Saving key: " . $key . " with value: " . $value;

		update_post_meta( $post_id, $key, sanitize_text_field( $value ) );
	}
}