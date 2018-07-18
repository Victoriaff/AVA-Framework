<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'AVA_Fields_Container' ) ) {
	class AVA_Fields_Container {

		public $id;

		public $params;

		public $default = array(
			'appearance' => array(
				'nav_style' => 'horizontal',

			)
		);

		public $sections;

		public $html;

		public $options;


		public function __construct( $params ) {

			// Set default values
			$params = AVA_Fields_Utils::params_default( $params, $this->default );

			$this->id = $params['container']['id'];

			$this->params = $params;


			$this->options = new AVA_Fields_Options( $params );
		}

		public function add_section( $id, $params ) {

			$section = new AVA_Fields_Section( $this, $id, $params );

			if ( $section ) {
				$this->sections[ $id ] = $section;
			}

			return $section;
		}


		public function render() {

			$this->html = '<div class="avaf" >';

			$this->html .= '<form class="avaf-form" method="post" data-nonce="de9b85ac62" enctype="multipart/form-data" data-container="' . esc_attr( $this->id ) . '">';

			$this->html .= $this->get_header();


			$active_section = $this->get_active_section();


			// Navigation menu
			$this->html .= '<div class="avaf-nav ' . esc_attr( $this->params['appearance']['nav_style'] ) . '">';

			foreach ( $this->sections as $obj_id => $obj_section ) {

				$active_class = ( $active_section == $obj_section->id ? 'active' : '' );

				$this->html .= '<a class="avaf-nav-item ' . esc_attr( $active_class ) . '" href="#' . esc_attr( $obj_section->id ) . '" data-section="' . esc_attr( $obj_section->id ) . '">';

				if ( ! empty( $obj_section->params['icon'] ) ) {
					$this->html .= '<img class="avaf-nav-icon" src="' . esc_url( $obj_section->params['icon'] ) . '">';
				}
				$this->html .= '<span>' . $obj_section->params['title'] . '</span>';
				$this->html .= '</a>';
			}
			$this->html .= '</div>';
			// end Navigation menu


			// Sections
			$this->html .= '<div class="avaf-sections ' . esc_attr( $this->params['appearance']['nav_style'] ) . '">';
			foreach ( $this->sections as $obj_id => $obj_section ) {
				$this->html .= $obj_section->render( array(
						'active' => $active_section
					)
				);
			}
			$this->html .= '</div>';
			// end Section

			// Control panel
			$this->html .= '<div class="avaf-control">';
			$this->html .= '<input type="submit" class="button-primary avaf-submit avaf-save" data-container="' . esc_attr( $this->id ) . '" value="'.__('Save Changes', '').'">';
			$this->html .= '<input type="submit" class="button avaf-submit avaf-reset-section" data-container="' . esc_attr( $this->id ) . '" value="'.__('Reset Section', '').'">';
			$this->html .= '<input type="submit" class="button avaf-submit avaf-reset" data-container="' . esc_attr( $this->id ) . '" value="'.__('Reset All', '').'">';
			$this->html .= '</div>';

			$this->html .= '</form>';


			$this->html .= '</div>';
			// end Control panel



			$this->html .= '</div>';

			return $this->html;

		}

		public function get_header() {

			$html = '';
			if ( ! empty( $this->params['container']['title'] ) || ! empty( $this->params['container']['subtitle'] ) ) {
				$html = '<div class="avaf-header">';

				$html .= '<div class="avaf-title">' . $this->params['container']['title'] . '</div>';
				$html .= '<div class="avaf-subtitle">' . $this->params['container']['subtitle'] . '</div>';

				$html .= '</div>';
			}

			return $html;
		}


		public function get_active_section() {
			return 'general';
		}


	}
}

