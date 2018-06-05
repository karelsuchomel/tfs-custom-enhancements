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

	if ( $is_autosave || $is_revision || !$is_valid_nonce )
	{
		return;
	}

	global $wpdb;
	$metaBasedOnContent = array (
		'gallery_included' => false,
	);

	$postContent = $wpdb->get_var( "SELECT `post_content` FROM {$wpdb->prefix}posts WHERE `ID` = {$post_id}");
	$postContent = mb_convert_encoding($postContent, 'HTML-ENTITIES', 'UTF-8');

	if ( !empty($postContent) ) 
	{
		// if there are text anchortags with non-image contents that are not download buttons
		// add a special class, also, if the link is off site, add another special class
		try {
			require_once("parse-text-links.php");
			$postContent = parseTextLinks($postContent);
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}	

		// find stand-alone images and parse them to work with **PSWgallery**
		try {
			require_once("parse-stand-alone-images.php");
			$postContent = parseStandAloneImages($postContent, $post_id);
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

		// if the content icludes gallery, fill the shortcode's defaults [gallery columns="4" link="file" size="medium"]
		// find if the content includes gallery
		try {
			require_once("parse-shortcode-galleries.php");
			list($postContent, $metaBasedOnContent['gallery_included']) = parseGalleries($postContent, $metaBasedOnContent['gallery_included']);
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

		// handle custom post meta based on the content
		// now only saves the meta values generated with parsing functions
		try {
			require_once("handle-post-meta-based-on-content.php");
			handlePostMetaBasedOnContent($metaBasedOnContent, $post_id);
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

		// Save new content into database
		$wpdb->update( $wpdb->prefix . "posts", array('post_content' => $postContent), array("ID" => $post_id), $format = null, $where_format = null );
	}

	// handle harmonogram meta
	if ( isset( $_POST['deadline-date'] ) && $_POST['deadline-date'] !== "" )
	{
		update_post_meta( $post_id, 'deadline-date', sanitize_text_field( $_POST['deadline-date'] ) );

		if ( isset( $_POST['harmonogram-title'] ) && $_POST['deadline-date'] !== "" )
		{
			update_post_meta( $post_id, 'harmonogram-title', sanitize_text_field( $_POST['harmonogram-title'] ) );
		} else {
			// insert title
			global $wpdb;
			$where = array( 'ID' => $post_id );
			$wpdb->update( $wpdb->posts, array( 'post_title' => $_POST['deadline-date'] ), $where );
		}
	}
}
add_action( 'save_post', 'tfs_post_meta_save' );