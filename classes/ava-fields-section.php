<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Section' ) ) {
	class AVA_Fields_Section {
		public $id;

		public $params;

		public $fields;

		public $container;

		public $html;


		/**
		 * Constructor.
		 *
		 * @param $params
		 */
		public function __construct( AVA_Fields_Container $container, $id, $params ) {
			global $wp_filesystem;

			$this->container = $container;
			$this->id        = $id;
			$this->params    = $params;

			if ( ! empty( $params['fields'] && is_array( $params['fields'] ) ) ) {

				foreach ( $params['fields'] as $id => $param ) {

					if ( preg_match( '/^[a-z0-9_]+$/', $param['type'] ) ) {
						$class = 'AVA_Field_' . $param['type'];

						if ( ! class_exists( $class ) ) {
							$file = AVA_FIELDS_FIELDS_DIR . 'ava-field-' . $param['type'] . '.php';

							if ( $wp_filesystem->exists( $file ) ) {
								require_once( $file );

							}
						}

						// Add field
						if ( class_exists( $class ) ) {

							$field = new $class( $this, $id, $param );
							if ( $field ) {
								$this->fields[ $id ] = $field;
							}


						}
					}
				}


			}
		}

		public function render( $args ) {

			$classes = array();

			if ( $args['active'] == $this->id ) {
				$classes[] = 'active';
			}

			$this->html = '<div class="avaf-section ' . esc_attr( implode( ' ', $classes ) ) . '" data-section="' . esc_attr( $this->id ) . '">';

			foreach ( $this->fields as $obj_id => $obj_field ) {
				$this->html .= $obj_field->render();
			}

			$this->html .= '</div>';

			return $this->html;

		}

	}
}

