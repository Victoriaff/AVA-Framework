<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

abstract class AVA_Shortcode_Core {

	/** Generate shortcode's content */
	abstract public function content( $atts, $content = null );
	
}

