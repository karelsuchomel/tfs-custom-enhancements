<?php
// if there are text anchortags with non-image contents that are not download buttons
// add a special class, also, if the link is off site, add another special class

function parseTextLinks( $postContent )
{

	// var_dump($postContent);
	// echo "<hr>";

	$dom = new DOMDocument('1.0', 'utf-8');
	//turning off some errors
	libxml_use_internal_errors(true);
	$dom->preserveWhiteSpace = false;
	// thanks to flags
	// in the output, there will be no doctype, html or body tags
	$dom->loadHTML("<div>".$postContent."</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

	function inspectNode(DOMNode $domNode, $domOriginal) 
	{
		foreach ($domNode->childNodes as $node) 
		{
			// if it's anchor that does not have a image inside it and does not have "download-button" class
			if ($node->nodeName === "a" && $node->firstChild->nodeName !== "img" && strpos($node->getAttribute('class'), "download-button") === false){
				// add the "text-link" class
				$node->setAttribute("class", "text-link");

				if (strpos($node->getAttribute('href'), home_url()) === false && strpos($node->getAttribute('href'), ".") !== false) {
					$node->setAttribute("target", "blank");
					$node->setAttribute("class", "text-link off-site-link");
				}

				//echo $node->getAttribute("class") . "<hr>";
			}
			if ($node->hasChildNodes()) {
				inspectNode($node, $domOriginal);
			}
		}
	}

	inspectNode($dom, $dom);

	$postContent = $dom->saveHTML();
	// remove the wrapping <div> tag that is needed for Libxml to work
	// because it does weird things when it does not have one root element
	$postContent = substr( $postContent, 5, strlen($postContent) - 7);

	// var_dump($postContent);
	// echo "<hr>";

	return $postContent;
}