<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class AVA_Studio_Options {

	// Default options
	private static $options = [
		'general' => [
			'b' => 11,
			'c' => 12
		]
	];

	/**
	 * Core singleton class
	 * @var self - pattern realization
	 */
	//private static $instance;

	/**
	 * Get the instane of WMP_EW
	 *
	 * @return self
	 */
	 /**
	public static function getInstance() {
		if ( ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    */

    public function __construct() {

        // Init options
        foreach(self::$options as $option=>$data) {
            $options = get_option( 'ava_studio_'.$option );
            //dump($options);
            if (!empty($options)) {
                self::$options[$option] = $options;
            } else {
	            //dump('Save option: '.$option);
                $this->store($option, $data);
            }
        }

    }

	public function get($option=null) {

		if (!$option) return self::$options;

		$el = explode('.', $option);

		$options = self::$options;
		$return = null;

		foreach($el as $option) {
			if (isset($options[$option])) {
				$options = $options[$option];
				$return = $options;
			} else
				return $return;
		}
		return $return;
	}

	public function update($option, $data) {
		$el = explode('.', $option);
		$options =& self::$options;

		foreach($el as $key=>$option) {

			if (isset($options[$option])) {
				if ($key < count($el)-1) $options =& $options[$option];
			} else {
				if ($key < count($el)-1) {
					$options =& $options[ $option ];
				} else {
					$options[ $option ] = $data;
					return $this;
				}
			}
		}
		$options[$option] = $data;

		return $this;
	}

	public function store($option, $data) {
		$this->update($option, $data);
		$opt = explode('.', $option)[0];
		$this->save($opt);
	}


	public function save($option=null) {
		if (!$option) {
			foreach(self::$options as $option)
				update_option( 'ava_studio_' . $option, self::$options[ $option ] );
		} else
			update_option( 'ava_studio_' . $option, isset( self::$options[ $option ] ) ? self::$options[ $option ] : [ ] );
	}

	public function remove($option) {
		if ( isset(self::$options[$option]) ) unset(self::$options[$option]);
		delete_option( 'ava_studio_' . $option );
	}

}

