<?php
namespace wpreactr;

/**
 * Class to register rest routes in WordPress.
 */
class WPR_Rest_Route {
	/**
	 * Instance of this class.
	 *
	 * @since    0.8.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1
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
	 * Hook into WordPress.
	 *
	 * @since     0.1
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}


	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'wp-reactr/v1';
		$endpoint  = '/example/';

		// Get example.
		register_rest_route(
			$namespace,
			$endpoint,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_example' ),
					'permission_callback' => array( $this, 'example_permissions_check' ),
					'args'                => array(),
				),
			)
		);

		// Create example.
		register_rest_route(
			$namespace,
			$endpoint,
			array(
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'update_example' ),
					'permission_callback' => array( $this, 'example_permissions_check' ),
					'args'                => array(),
				),
			)
		);

		// Update example.
		register_rest_route(
			$namespace,
			$endpoint,
			array(
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_example' ),
					'permission_callback' => array( $this, 'example_permissions_check' ),
					'args'                => array(),
				),
			)
		);

		// Delete example.
		register_rest_route(
			$namespace,
			$endpoint,
			array(
				array(
					'methods'             => \WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_example' ),
					'permission_callback' => array( $this, 'example_permissions_check' ),
					'args'                => array(),
				),
			)
		);

	}

	/**
	 * Get Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function get_example( $request ) {
		$example_option = get_option( 'wpr_example_setting' );

		return new \WP_REST_Response(
			array(
				'success' => true,
				'value'   => $example_option,
			),
			200
		);
	}

	/**
	 * Create OR Update Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function update_example( $request ) {
		$updated = update_option( 'wpr_example_setting', $request->get_param( 'exampleSetting' ) );

		return new \WP_REST_Response(
			array(
				'success' => $updated,
				'value'   => $request->get_param( 'exampleSetting' ),
			),
			200
		);
	}

	/**
	 * Delete Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_example( $request ) {
		$deleted = delete_option( 'wpr_example_setting' );

		return new \WP_REST_Response(
			array(
				'success' => $deleted,
				'value'   => '',
			),
			200
		);
	}

	/**
	 * Check if a given request has access to update a setting
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function example_permissions_check( $request ) {
		return current_user_can( 'manage_options' );
	}
}
