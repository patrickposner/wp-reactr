<?php

namespace wpreactr;

/**
 * Class which handles the shortcode registration in WordPress.
 */
class WPR_Shortcode {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize the class and hook into WP:
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		add_shortcode( 'wp-reactr', array( $this, 'render_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_scripts' ) );
	}


	/**
	 * Register frontend-specific styles and scripts.
	 *
	 * @since     1.0.0
	 */
	public function register_frontend_scripts() {
		wp_register_script( 'wpreactr-shortcode-js', plugins_url( 'assets/js/wpr-shortcode.js', dirname( __FILE__ ) ), array( 'jquery' ), '0.1.0', true );
		wp_register_style( 'wpreactr-shortcode-css', plugins_url( 'assets/css/wpr-shortcode.css', dirname( __FILE__ ) ), '0.1.0', 'all' );
	}

	/**
	 * Render the shortcode on the frontend.
	 *
	 * @param  array $atts array of optional arguments.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		wp_enqueue_script( 'wpreactr-shortcode-js' );
		wp_enqueue_style( 'wpreactr-shortcode-css' );

		$object_name = 'wpr_object_' . uniqid();

		$object = shortcode_atts(
			array(
				'title'     => 'Hello world',
				'api_nonce' => wp_create_nonce( 'wp_rest' ),
				'api_url'   => rest_url( 'wp-reactr/v1/' ),
			),
			$atts,
			'wp-reactr'
		);

		wp_localize_script( 'wpreactr-shortcode-js', $object_name, $object );

		$shortcode = '<div class="wp-reactr" data-object-id="' . $object_name . '"></div>';
		return $shortcode;
	}
}
