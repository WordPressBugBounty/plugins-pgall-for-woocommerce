<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Payment_Gateway' ) ) {

	if ( ! class_exists( 'WC_Gateway_Lguplus_Applepay' ) ) {

		class WC_Gateway_Lguplus_Applepay extends WC_Gateway_Lguplus {

			public function __construct() {
				$this->id = 'lguplus_applepay';

				parent::__construct();

				if ( empty( $this->settings['title'] ) ) {
					$this->title       = __( '애플페이', 'pgall-for-woocommerce' );
					$this->description = __( '애플페이로 결제합니다.', 'pgall-for-woocommerce' );
				} else {
					$this->title       = $this->settings['title'];
					$this->description = $this->settings['description'];
				}

				$this->supports[] = 'refunds';
			}
			public function is_available() {
				if ( wp_is_mobile() ) {
					$available = preg_match( "/iPhone|iPad/", pafw_get( $_SERVER, 'HTTP_USER_AGENT' ) );
				} else {
					$user_agent = pafw_get( $_SERVER, 'HTTP_USER_AGENT' );

					$available = ! empty( $user_agent ) && str_contains( $user_agent, 'Macintosh' ) && ! str_contains( $user_agent, 'Chrome' );
				}

				return parent::is_available() && $available;
			}
			public function process_approval_response( $order, $response ) {
				$order->update_meta_data( "_pafw_card_num", pafw_get( $response, 'card_num' ) );
				$order->update_meta_data( "_pafw_card_code", pafw_get( $response, 'card_code' ) );
				$order->update_meta_data( "_pafw_card_bank_code", pafw_get( $response, 'card_bank_code' ) );
				$order->update_meta_data( "_pafw_card_name", pafw_get( $response, 'card_name' ) );
				$order->update_meta_data( "_pafw_card_other_pay_type", $response['card_other_pay_type'] );
				$order->save_meta_data();

				$this->add_payment_log( $order, '[ 결제 승인 완료 ]', array(
					'거래번호' => $response['transaction_id']
				) );
			}
		}
	}

}
