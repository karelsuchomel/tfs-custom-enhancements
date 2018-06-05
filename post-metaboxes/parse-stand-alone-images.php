<?php
// find stand-alone images and parse them to work with PSWgallery
function parseStandAloneImages( $postContent, $post_id )
{
	global $wpdb;

	// Get anchors in the content
	$imagesURL;
	$dom = new DOMDocument('1.0', 'utf-8');
	//turning off some errors
	libxml_use_internal_errors(true);
	// <div> is here, because LIBXML library require one root element
	$dom->loadHTML("<div>".$postContent."</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
	$anchors = $dom->getElementsByTagName('a');
	foreach ($anchors as $element) {
		if ($element->firstChild->nodeName === "img") 
		{
			$imageURL = $element->getAttribute('href');

			// get the ID
			$imageID = $wpdb->get_var( "SELECT `ID` FROM {$wpdb->prefix}posts WHERE `guid` = '{$imageURL}'");
			if ( $imageID === NULL || $imageID === false || wp_attachment_is_image($imageID) === false ) {
				continue;
			}

			// Get dimensions of images
			$imageWidth;
			$imageHeight;
			if ( $imageID !== false ) {
				$results = unserialize( $wpdb->get_var( "SELECT `meta_value` FROM {$wpdb->prefix}postmeta WHERE `post_id` = '{$imageID}' AND `meta_key` = '_wp_attachment_metadata'") );
				$imageWidth = $results['width'];
				$imageHeight = $results['height'];
			}

			$element->setAttribute( "data-size", $imageWidth . "x" . $imageHeight);
			$element->setAttribute( "class", "pswp-gallery");

		}
	}

	// echo "<hr>";
	// var_dump($imageURL);

	// echo "<hr>";
	// var_dump($imageID);

	// echo "<hr>";
	// print_r($imageWidth . "x" . $imageHeight);

	$postContent = $dom->saveHTML();
	// remove the wrapping <div> tag that is needed for Libxml to work
	// because it does weird things when it does not have one root element
	$postContent = substr( $postContent, 5, strlen($postContent) - 12);

	// var_dump($postContent);
	// echo "<hr>";

	return $postContent;
}