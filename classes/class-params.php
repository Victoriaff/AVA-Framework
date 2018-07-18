<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class AVA_Studio_Params {

	public $params;

    public function __construct() {

    }

	/** Load custom params */
	public function load() {

		foreach ( glob( AVA_STUDIO_PLUGIN_DIR . 'admin/params/*.php' ) as $file ) {

			$params = require_once $file;

			//$params['admin_enqueue_js'] = AVA_STUDIO_PLUGIN_DIR.'/admin/assets/js/admin.js';
			//$params['admin_enqueue_css'] = AVA_STUDIO_PLUGIN_DIR.'/admin/assets/css/params.css';

			if (!empty($params) && is_array($params) && function_exists('vc_add_shortcode_param')) {
				//dump($params);
				vc_add_shortcode_param( $params['type'], $params['callback'] );

				$param = preg_replace('/\.php/', '', basename($file));
				$this->params[ $param ] = $params;
			}
		}

		//dump($this->params);
	}
}

