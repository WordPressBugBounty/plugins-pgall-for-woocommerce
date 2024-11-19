<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class PAFW_Admin_Post_Types {
	public static function init() {
		add_filter( 'manage_users_columns', array( __CLASS__, 'manage_users_columns' ) );
		add_filter( 'manage_users_custom_column', array( __CLASS__, 'manage_users_custom_column' ), 10, 3 );
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
			$users_columns['pafw_customer_tokens'] = __( '결제수단', 'pgall-for-woocommerce' );
		}

		return $users_columns;
	}
}

PAFW_Admin_Post_Types::init();
