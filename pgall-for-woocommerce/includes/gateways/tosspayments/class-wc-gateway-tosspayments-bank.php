<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Payment_Gateway' ) ) {

	if ( ! class_exists( 'WC_Gateway_TossPayments_Bank' ) ) {

		class WC_Gateway_TossPayments_Bank extends WC_Gateway_TossPayments {

			public function __construct() {
				$this->id = 'tosspayments_bank';

				parent::__construct();

				if ( empty( $this->settings[ 'title' ] ) ) {
					$this->title       = __( '퀵계좌이체', 'pgall-for-woocommerce' );
					$this->description = __( '계좌에서 바로 결제하는 퀵계좌이체 입니다.', 'pgall-for-woocommerce' );
				} else {
					$this->title       = $this->settings[ 'title' ];
					$this->description = $this->settings[ 'description' ];
				}

				$this->title = str_replace( "실시간 계좌이체", "퀵계좌이체", $this->title );

				if ( __( "실시간 계좌이체를 진행합니다.", 'pgall-for-woocommerce' ) == $this->description ) {
					$this->description = __( '계좌에서 바로 결제하는 퀵계좌이체 입니다.', 'pgall-for-woocommerce' );
				}

				$this->supports[] = 'pafw-cash-receipt';
			}
			public function process_approval_response( $order, $response ) {
				$order->update_meta_data( "_pafw_bank_code", $response[ 'bank_code' ] );
				$order->update_meta_data( "_pafw_bank_name", $response[ 'bank_name' ] );
				$order->update_meta_data( "_pafw_cash_receipts", $response[ 'cash_receipts' ] );
				$order->update_meta_data( "_pafw_receipt_url", pafw_get( $response, 'receipt_url' ) );
				$order->save_meta_data();

				$this->add_payment_log( $order, '[ 결제 승인 완료 ]', array(
					'거래번호' => $response[ 'transaction_id' ]
				) );
			}
		}
	}

} // class_exists function end
