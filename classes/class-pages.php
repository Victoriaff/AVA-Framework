<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class AVA_Studio_Pages {

	private $params;

    public function __construct() {
    }

	public function shortcodes() {
		echo 'Page shortcodes';
	}

	public function settings() {
		echo 'Page settings';

		//WPM_Form::switchButton('switch1', 1, '');
		//WPM_Form::switchButton('switch2', 1, 'wmpSwitch');
		//WPM_Form::switchButton('switch3', 0, 'wmpSwitch');
	}

	public function about() {
		echo 'Page about';
	}
}

