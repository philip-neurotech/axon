<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Elementor_Integration {

	public function editor_head() {
		?><style>.pojo-widget-button-collapse.widget-button-collapse { display: none; }</style><?php
	}

	public function __construct() {
		add_action( 'elementor/editor/wp_head', array( $this, 'editor_head' ) );
	}
}

new Pojo_Elementor_Integration();
