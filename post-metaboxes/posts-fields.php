<?php

function tfs_post_add_custom_metabox()
{
	add_meta_box(
		'tfs_post_meta',
		__( 'Additional post details' ),
		'tfs_post_meta_callback',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tfs_post_add_custom_metabox' );

function tfs_post_meta_callback( $post )
{
	// security feature
	wp_nonce_field( basename( __FILE__ ), 'tfs_post_nonce' );
	$tfs_stored_data = get_post_meta( $post->ID );
?>
	<div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="deadline-date" class="row-title">Datum konání:</label>
			</div>
			<div class="meta-td">
				<input type="text" name="deadline-date" id="deadline-date" class="datepicker" value="<?php if ( ! empty($tfs_stored_data['deadline-date']) ) echo esc_attr( $tfs_stored_data['deadline-date'][0] ); ?>">
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="harmonogram-title" class="row-title">Název v harmonogramu:</label>
			</div>
			<div class="meta-td">
				<input type="text" name="harmonogram-title" id="harmonogram-title" value="<?php if ( ! empty($tfs_stored_data['harmonogram-title']) ) echo esc_attr( $tfs_stored_data['harmonogram-title'][0] ); ?>">
			</div>
		</div>
	</div>
<?php	
}

function tfs_post_meta_save( $post_id )
{
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['tfs_post_nonce'] ) && wp_verify_nonce( $_POST['tfs_post_nonce'], basename(__FILE__) ) ) ? 'true' : 'false';

	// Exists script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce )
	{
		return;
	}

	if ( isset( $_POST['deadline-date'] ) )
	{
		update_post_meta( $post_id, 'deadline-date', sanitize_text_field( $_POST['deadline-date'] ) );

		// // insert title
		// global $wpdb;
		// $where = array( 'ID' => $post_id );
		// $wpdb->update( $wpdb->posts, array( 'post_title' => $_POST['deadline-date'] ), $where );
	}
	if ( isset( $_POST['harmonogram-title'] ) )
	{
		update_post_meta( $post_id, 'harmonogram-title', sanitize_text_field( $_POST['harmonogram-title'] ) );
	}
}
add_action( 'save_post', 'tfs_post_meta_save' );