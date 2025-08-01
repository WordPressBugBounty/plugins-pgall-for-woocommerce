<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class PAFW_Admin_Post_Types {
	public static function init() {
		add_filter( 'manage_users_columns', array( __CLASS__, 'manage_users_columns' ) );
		add_filter( 'manage_users_custom_column', array( __CLASS__, 'manage_users_custom_column' ), 10, 3 );

		if ( PAFW_HPOS::enabled() ) {
			add_action( 'woocommerce_order_list_table_restrict_manage_orders', array( __CLASS__, 'output_payment_gateway_filter' ) );
			add_filter( 'woocommerce_shop_order_list_table_prepare_items_query_args', array( __CLASS__, 'add_shop_order_list_table_prepare_items_query_args' ) );
		} else {
			add_action( 'restrict_manage_posts', array( __CLASS__, 'output_payment_gateway_filter' ), 30 );
			add_filter( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ), 100 );
		}
	}
	static function output_payment_gateway_filter( $order_type = '' ) {
		global $typenow;

		if ( ! PAFW_HPOS::enabled() ) {
			$order_type = $typenow;
		}

		if ( in_array( $order_type, wc_get_order_types( 'order-meta-boxes' ) ) ) {
			$selected_payment_gateway = isset( $_REQUEST[ 'pafw_payment_gateway' ] ) ? wc_clean( wp_unslash( $_REQUEST[ 'pafw_payment_gateway' ] ) ) : '';

			$payment_gateways = WC()->payment_gateways()->get_available_payment_gateways();

			echo '<select name="pafw_payment_gateway">';
			printf( __( '<option value="" %s>모든 결제수단</option>', 'pgall-for-woocommerce' ), $selected_payment_gateway == '' ? 'selected' : '' );
			foreach ( $payment_gateways as $payment_gateway ) {
				printf( '<option value="%s" %s>%s</option>', $payment_gateway->id, $selected_payment_gateway == $payment_gateway->id ? 'selected' : '', $payment_gateway->title );
			}
			echo '<select>';
		}
	}
	public static function add_shop_order_list_table_prepare_items_query_args( $order_query_args ) {
		if ( ! empty( $_REQUEST[ 'pafw_payment_gateway' ] ) ) {
			$order_query_args[ 'payment_method' ] = $_REQUEST[ 'pafw_payment_gateway' ];
		}

		return $order_query_args;
	}
	public static function pre_get_posts( $q ) {
		global $typenow;

		if ( 'shop_order' != $typenow ) {
			return;
		}

		if ( ! is_feed() && is_admin() && $q->is_main_query() ) {

			if ( ! empty( $_REQUEST[ 'pafw_payment_gateway' ] ) ) {
				$meta_query = $q->get( 'meta_query' );

				if ( empty( $meta_query ) ) {
					$meta_query = array();
				}

				$meta_query[] = array(
					'key'     => '_payment_method',
					'value'   => sanitize_text_field( $_REQUEST[ 'pafw_payment_gateway' ] ),
					'compare' => '='
				);

				$q->set( 'meta_query', $meta_query );
			}
		}
	}
	public static function manage_users_custom_column( $value, $column_name, $user_id ) {
		if ( 'pafw_customer_tokens' == $column_name ) {
			$tokens = WC_Payment_Tokens::get_customer_tokens( $user_id );

			$outputs = array();

			foreach ( $tokens as $token ) {
				$outputs[] = sprintf( "%s", $token->get_display_name() );
			}

			return implode( "<br>", $outputs );
		}

		return $value;
	}
	public static function manage_users_columns( $users_columns ) {
		if ( apply_filters( 'pafw_show_customer_tokens', true ) ) {
			$users_columns[ 'pafw_customer_tokens' ] = __( '결제수단', 'pgall-for-woocommerce' );
		}

		return $users_columns;
	}
}

PAFW_Admin_Post_Types::init();
