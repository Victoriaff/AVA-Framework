<?php
if (!defined( 'ABSPATH' )) {
	die( '-1' );
}

if (!class_exists( 'AVA_Field_Text' )) {
	class AVA_Field_Text extends AVA_Fields_Field
	{
		public $type = 'text';


		public function __construct(AVA_Fields_Section $section, $id, $params) {
			parent::__construct( $section, $id, $params );

			$this->add_class('avafl-text');
		}

		public function build() {

			$this->html = '<input type="text" name="' . $this->get_name_attr() . '" id="' . $this->get_id_attr() . '" value="' . esc_attr( $this->value ) . '" ' . $this->get_attrs() . '>';

		}


	}
}

