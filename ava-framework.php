<?php
/*
Plugin Name: AVA Framework
Plugin URI: http://framework.ava-team.com
Description: Just add live to your pages
Version: 1.0.0
Author: AVA-Team.com
Author URI: http://ava-team.com
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*
if (!defined( 'AVA_FIELDS_ASSETS_DIR' )) {
	define( 'AVA_FIELDS_ASSETS_DIR', __DIR__ . '/assets/' );
}
if (!defined( 'AVA_FIELDS_ASSETS_URI' )) {
	define( 'AVA_FIELDS_ASSETS_URI', get_template_directory_uri() . '/vendor/ava-fields/assets/' );
}

if (!defined( 'AVA_FIELDS_FIELDS_DIR' )) {
	define( 'AVA_FIELDS_FIELDS_DIR', __DIR__ . '/fields/' );
}
if (!defined( 'AVA_FIELDS_ICONS_DIR' )) {
	define( 'AVA_FIELDS_ICONS_DIR', __DIR__ . '/assets/images/icons/' );
}
if (!defined( 'AVA_FIELDS_ICONS_URI' )) {
	define( 'AVA_FIELDS_ICONS_URI', get_template_directory_uri() . '/vendor/ava-fields/assets/images/icons/' );
}
*/

//dd(1);
if ( ! class_exists( 'AVA_Framework' ) ) {
	class AVA_Framework {
		const VERSION = '1.0';
		
		const SLUG = 'Core';
		
		/**
		 * Core singleton class
		 * @var self - pattern realization
		 */
		private static $instance;
		
		private $config = array(
			'dirs' => array(
				'shortcodes' => array(),
				'widgets'    => array(),
				'options'    => array(),
			),
			'shortcodes' => array(
				'support' => array('page_builder'),
			)
		);
		
		/**
		 * Modules and objects instances list
		 * @since 4.2
		 * @var array
		 */
		private $factory = array();
		
		private $filesystem;
		
		
		// Fields containers
		public $containers;
		
		// Shortcodes
		public $shortcodes;
		
		/**
		 * List of directories
		 *
		 * @since 1.0
		 * @var array
		 */
		private $fw_dirs = array();
		
		
		/**
		 * Class constructor
		 *
		 * @since  1.0
		 */
		public function __construct( $config = null ) {
			
			$dir = dirname( __FILE__ );
			
			//$this->set_config ($config);
			
			//global $wp_filesystem;
			//dd($wp_filesystem);
			
			//WP_Filesystem()
			//$this->filesystem =
			/** Load core files */
			//$this->load();
			$this->fw_dirs['fw_root'] = $dir;
			$this->fw_dirs['wp_root'] = preg_replace( '/$\//', '', ABSPATH );
			
			/*
			$this->set_path( 'SHORTCODES_DIR', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			$this->set_path( 'FW_ROOT', $dir);
			*/
			
			
			/*
			'APP_DIR' => basename( plugin_basename( $dir ) ),
			'CONFIG_DIR' => $dir . '/config',
			'ASSETS_DIR' => $dir . '/assets',
			'ASSETS_DIR_NAME' => 'assets',
			'AUTOLOAD_DIR' => $dir . '/include/autoload',
			'CORE_DIR' => $dir . '/include/classes/core',
			'HELPERS_DIR' => $dir . '/include/helpers',
			'SHORTCODES_DIR' => $dir . '/include/classes/shortcodes',
			'SETTINGS_DIR' => $dir . '/include/classes/settings',
			'TEMPLATES_DIR' => $dir . '/include/templates',
			'EDITORS_DIR' => $dir . '/include/classes/editors',
			'PARAMS_DIR' => $dir . '/include/params',
			'UPDATERS_DIR' => $dir . '/include/classes/updaters',
			'VENDORS_DIR' => $dir . '/include/classes/vendors',
			*/
			
			require_once( $this->fw_dirs['fw_root'] . '/classes/ava-shortcodes.php');
			
			$this->init();
			
		}
		
		public function init() {
			
			// Framework init hook
			do_action( 'AVAFW_' . self::SLUG . '/init' );
			
			// Get custom dirs
			//do_action( 'AVAFW_'.self::SLUG.'/custom_dirs' );
			
			// Get directories types
			$this->define_dirs();
			
			// Set directories
			$this->set_dirs();
			
			$this->load_shortcodes();
			
			// Set directories
			//$this->set_dirs();
			
			//$this->factory['options']   = new AVA_Studio_Options($this->options);
			//$this->factory['params'] = new AVA_Studio_Params();
			//$this->factory['shortcodes'] = new AVA_Studio_Shortcodes();
			//$this->factory['view'] = new AVA_Studio_View();
			//$this->factory['pages'] = new AVA_Studio_Pages();
			
			// Enqueue scripts
			//add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'), 5 );
			
			//add_action( 'wp_register_scripts', array($this, 'enqueue_scripts'), 5 );
			
			
			//add_action( 'admin_menu', array($this, 'admin_menu') );
			
			/** Ajax hooks */
			//add_action('wp_ajax_avaf-save', array('AVA_Fields_Options', 'save'));
			//add_action('wp_ajax_nopriv_avaf-save', array('AVA_Fields_Options', 'save'));
			
			//dump('init');
			
			
			//dump( '... Config ...' );
			//dump( $this->config );
			
		}
		
		/**
		 * Setter for paths
		 *
		 * @since  1.0
		 * @access protected
		 *
		 * @param $paths
		 */
		/*
		public function set_dir( $param, $path ) {
			$this->dirs[$param] = $path;
		}
		*/
		
		public function define_dirs() {
			$this->config['dirs'] = apply_filters( 'AVAFW_' . self::SLUG . '/define_dirs', $this->config['dirs'] );
		}
		
		public function set_dirs() {
			
			foreach ( $this->config['dirs'] as $dir => $value ) {
				$this->config['dirs'][ $dir ] = apply_filters( 'AVAFW_' . self::SLUG . '/dir/' . $dir, $value );
			}
			
			
		}
		
		
		public function load_shortcodes() {
			do_action( 'AVAFW_' . self::SLUG . '/shortcodes/load/before' );
			
			if ( isset($this->config['dirs']['shortcodes']) && is_array($this->config['dirs']['shortcodes'])) {
				foreach ( $this->config['dirs']['shortcodes'] as $dir ) {
					
					if ( is_dir($dir) ) {
						
						// Load shortcodes
						$shortcodes = glob( $dir.'/*', GLOB_ONLYDIR );
						
						foreach ( $shortcodes as $shortcode ) {
							//$shortcode_name = str_replace( '-', '_', basename( $shortcode ) );
							
							/*
							if ( in_array( $shortcode_name, $shortcodes ) ) {
								continue;
							}
							*/
							
							$config = require_once $shortcode . '/config.php';
							$shortcode_name = $config['shortcode'];
							
							$this->shortcodes[ $shortcode_name ] = array(
								'config' => $config
							);
							require_once $shortcode . '/shortcode.php';
						}
					}
					
				}
			}
			
			do_action( 'AVAFW_' . self::SLUG . '/shortcodes/load/after' );
			
			//dump($this->shortcodes);
		}
		
		
		/**
		 * Get the instane of WMP_EW
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
		
		/**
		 * Cloning disabled
		 */
		private function __clone() {
		}
		
		/**
		 * Serialization disabled
		 */
		private function __sleep() {
		}
		
		/**
		 * De-serialization disabled
		 */
		private function __wakeup() {
		}
		
		
	}
}

/*
if (!function_exists( 'ava_fw' )) {
	function ava_fields() {
		return AVA_Framework::instance();
	}

	ava_fw()->init();
}
*/




