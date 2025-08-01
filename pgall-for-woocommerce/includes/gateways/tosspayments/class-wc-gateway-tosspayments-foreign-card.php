<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Payment_Gateway' ) ) {

	if ( ! class_exists( 'WC_Gateway_TossPayments_Foreign_Card' ) ) {

		class WC_Gateway_TossPayments_Foreign_Card extends WC_Gateway_TossPayments {
			protected $foreign_card_settings = array();

			public function __construct() {
				$this->id = 'tosspayments_foreign_card';

				parent::__construct();

				if ( empty( $this->settings[ 'title' ] ) ) {
					$this->title       = __( '해외카드', 'pgall-for-woocommerce' );
					$this->description = __( '해외카드(Visa, MasterCard, JCB, UnionPay, AMEX)로 결제합니다.', 'pgall-for-woocommerce' );
				} else {
					$this->title       = $this->settings[ 'title' ];
					$this->description = $this->settings[ 'description' ];
				}

				$this->supports[] = 'refunds';

				$foreign_card_settings = $this->settings[ 'foreign_card_settings' ];
				if ( ! empty( $foreign_card_settings ) && is_array( $foreign_card_settings ) ) {
					$this->foreign_card_settings = array_combine( array_column( $foreign_card_settings, 'currency' ), $foreign_card_settings );
				}
			}
			function get_supported_currency() {
				return apply_filters( "pafw_{$this->id}_supported_currencies", array( 'USD', 'KRW', 'JPY' ) );
			}
			public function get_merchant_id( $order = null ) {
				$merchant_id = pafw_get( $this->settings, 'merchant_id' );

				if ( $order && isset( $this->foreign_card_settings[ $order->get_currency() ] ) ) {
					$merchant_id = pafw_get( $this->foreign_card_settings[ $order->get_currency() ], 'merchant_id', $merchant_id );
				}

				return $merchant_id;
			}
			public function get_merchant_key( $order = null ) {
				$merchant_key = pafw_get( $this->settings, 'merchant_key' );

				if ( $order && isset( $this->foreign_card_settings[ $order->get_currency() ] ) ) {
					$merchant_key = pafw_get( $this->foreign_card_settings[ $order->get_currency() ], 'merchant_key', $merchant_key );
				}

				return $merchant_key;
			}
			public function get_client_key( $order = null ) {
				$client_key = pafw_get( $this->settings, 'client_key' );

				if ( $order && isset( $this->foreign_card_settings[ $order->get_currency() ] ) ) {
					$client_key = pafw_get( $this->foreign_card_settings[ $order->get_currency() ], 'client_key', $client_key );
				}

				return $client_key;
			}
			public function get_secret_key( $order = null ) {
				$secret_key = pafw_get( $this->settings, 'secret_key' );

				if ( $order && isset( $this->foreign_card_settings[ $order->get_currency() ] ) ) {
					$secret_key = pafw_get( $this->foreign_card_settings[ $order->get_currency() ], 'secret_key', $secret_key );
				}

				return $secret_key;
			}
			public function process_approval_response( $order, $response ) {
				$order->update_meta_data( "_pafw_card_num", pafw_get( $response, 'card_num' ) );
				$order->update_meta_data( "_pafw_card_code", pafw_get( $response, 'card_code' ) );
				$order->update_meta_data( "_pafw_card_bank_code", pafw_get( $response, 'card_bank_code' ) );
				$order->update_meta_data( "_pafw_card_name", pafw_get( $response, 'card_name' ) );
				$order->update_meta_data( "_pafw_card_type", pafw_get( $response, 'card_type' ) );
				$order->update_meta_data( "_pafw_owner_type", pafw_get( $response, 'owner_type' ) );
				$order->update_meta_data( "_pafw_receipt_url", pafw_get( $response, 'receipt_url' ) );
				$order->save_meta_data();

				if ( ! empty( $response[ 'card_other_pay_type' ] ) ) {
					pafw_set_payment_method_title( $order, $this, $response[ 'card_other_pay_type' ] );
				}

				$this->add_payment_log( $order, '[ 결제 승인 완료 ]', array(
					'거래번호' => $response[ 'transaction_id' ]
				) );
			}
		}
	}

}
