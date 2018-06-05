<?php
// if the content includes gallery, fill the shortcode's defaults [gallery columns="4" link="file" size="medium" ]
// set the meta value of "gallery_included" to true/false
function parseGalleries( $postContent, $gallery_included )
{
	$galleryDefaults = 'columns="4" link="file" size="medium"';
	// there can be multiple galleries PREG_OFFSET_CAPTURE
	$re = '/\[gallery.*ids=".*"\]/m';
	preg_match_all($re, $postContent, $matches, PREG_OFFSET_CAPTURE, 0);

	if (isset($matches[0][0][0])) {
		$gallery_included = true;
	}

	var_dump($matches);

	$offset = 0;
	foreach ($matches as $matchSet) 
	{
		foreach ($matchSet as $matchInstance)
		{
			$attrEnd = strpos($matchInstance[0], "ids=\"");
			// echo "<hr>";
			// echo (int)$matchInstance[1] . "+ 8 + " . $offset . "... attrEnd: " . $attrEnd;

			// change content
			$postContent = substr($postContent, 0, (int)$matchInstance[1] + 8 + $offset) . " " . $galleryDefaults . " " . substr($postContent, $matchInstance[1] + $attrEnd + $offset, strlen($postContent) - 1);

			// calculate the offset from pasted gallery differences
			$offset = strlen($galleryDefaults) + 9 - $attrEnd + 1;
		}
	}

	// echo "<hr>";
	// var_dump($postContent);

	return array( $postContent, $gallery_included);
}