<?php



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PAFW_Endpoint {
	public function __construct() {
		// Actions used to insert a new endpoint in the WordPress.
		add_action( 'init', array( $this, 'add_endpoints' ) );
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );

		// Change the My Accout page title.
		add_filter( 'the_title', array( $this, 'endpoint_title' ) );
	}
	public static function get_endpoints() {
		return array(
			'pafw-ex' => __( '교환 및 반품', 'pgall-for-woocommerce' ),
		);
	}
	public function add_endpoints() {
		foreach ( self::get_endpoints() as $endpoint => $label ) {
			add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );
		}
	}
	public function add_query_vars( $vars ) {
		foreach ( self::get_endpoints() as $endpoint => $label ) {
			$vars[] = $endpoint;
		}

		return $vars;
	}
	public function endpoint_title( $title ) {
		global $wp_query;

		$is_endpoint = isset( $wp_query->query_vars['pafw-ex'] );

		if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
			if ( PAFW_Exchange_Return_Manager::support_exchange() && PAFW_Exchange_Return_Manager::support_return() ) {
				$label = __( '교환 / 반품', 'pgall-for-woocommerce' );
			} else if ( PAFW_Exchange_Return_Manager::support_exchange() ) {
				$label = __( '교환', 'pgall-for-woocommerce' );
			} else {
				$label = __( '반품', 'pgall-for-woocommerce' );
			}

			// New page title.
			$title = $label;

			remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
		}

		return $title;
	}
	public static function install() {
		foreach ( self::get_endpoints() as $endpoint => $label ) {
			add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );
		}

		flush_rewrite_rules();
	}
}

new PAFW_Endpoint();
