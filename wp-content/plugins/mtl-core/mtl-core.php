<?php 
/*
  Plugin Name: MTL Core
  Description: MTL Core plugin for elementor widgets.
  Version: 1.0
  Author: MTL
  Text Domain: mtl-core
*/

namespace MTLCore;

/**
 * Class Elementor_Post_Widget_Main
 *
 * Main Plugin class
 * @since 1.2.0
 */
class MTL_Core_Main {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
  
     /**
	 * Initialize the plugin
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function init() {
   		require_once( 'custom-post.php' );
    }

	/**
	 * widget_style
	 *
	 * Load main style files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_styles() {
		wp_register_style( 'mtl-core-style', plugins_url( '/assets/css/main.css', __FILE__ ) );
		wp_enqueue_style( 'mtl-core-style' );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_files() {
		require_once( __DIR__ . '/widgets/post/post.php' );
        require_once( __DIR__ . '/widgets/services/services.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets($widgets_manager) {
		// Its is now safe to include Widgets files
		$this->include_files();

		// Register Widgets
        $widgets_manager->register( new Widgets\Elementor_Post_Widget() );
        $widgets_manager->register( new Widgets\Elementor_Services_Widget() );
	}


	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
      
		// Register widget style
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

	}
}

// Instantiate Plugin Class
MTL_Core_Main::instance();