<?php
/**
* Plugin Name: Tvorba jídelníčků
* Description: Tvorba jídelníčku pro tento a příští týden.
* Author: Karel Suchomel
* Version: 0.1
* License: MIT license
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ))
{
	exit;
}

require_once ( plugin_dir_path(__FILE__) . 'lm-custom-post-type.php' );
require_once ( plugin_dir_path(__FILE__) . 'lm-fields.php' );


?>