<?php
// phpcs:disable WordPress.Security.NonceVerification

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Payment_Gateway' ) ) {

	if ( ! class_exists( 'WC_Gateway_SettlePG_Vbank' ) ) {

		class WC_Gateway_SettlePG_Vbank extends WC_Gateway_SettlePG{ // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound

			public function __construct() {

				$this->id = 'settlepg_vbank';

				parent::__construct();

				if ( empty( $this->settings['title'] ) ) {
					$this->title       = __( '가상계좌', 'pgall-for-woocommerce' );
					$this->description = __( '가상계좌로 결제합니다.', 'pgall-for-woocommerce' );
				} else {
					$this->title       = $this->settings['title'];
					$this->description = $this->settings['description'];
				}

				$this->supports[] = 'pafw-cash-receipt';
				$this->supports[] = 'pafw-vbank';
			}
			public function process_approval_response( $order, $response ) {
				$order->update_meta_data( '_pafw_vacc_tid', $response['vacc_tid'] );
				$order->update_meta_data( '_pafw_vacc_num', $response['vacc_num'] );
				$order->update_meta_data( '_pafw_vacc_bank_code', $response['vacc_bank_code'] );
				$order->update_meta_data( '_pafw_vacc_bank_name', $response['vacc_bank_name'] );
				$order->update_meta_data( '_pafw_vacc_holder', $response['vacc_holder'] );
				$order->update_meta_data( '_pafw_vacc_depositor', $response['vacc_depositor'] );
				$order->update_meta_data( '_pafw_vacc_date', $response['vacc_date'] );
				$order->update_meta_data( '_pafw_cash_receipts', $response['vacc_tid'] );

				$this->add_payment_log( $order, '[ 가상계좌 입금 대기중 ]', array(
					'거래번호' => $response['vacc_tid']
				) );

				//가상계좌 주문 접수시 재고 차감여부 확인
				pafw_reduce_order_stock( $order );

				$order->update_status( $this->settings['order_status_after_vbank_payment'] );

				$order->set_date_paid( null );
				$order->save();
			}
			public function process_vbank_noti() {
				$this->add_log( '가상계좌 입금통보 시작 : ' . print_r( wc_clean( $_REQUEST ), true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r

				try {
					if ( $this->get_merchant_id() != pafw_get_unslash( $_POST, 'mchtId' ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '2001' );
					}

					if ( '0021' != pafw_get_unslash( $_POST, 'outStatCd' ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), pafw_get_unslash( $_POST, 'outStatCd' ) );
					}

					$order_id = $this->get_order_id_from_txnid( pafw_get_unslash( $_POST, 'mchtTrdNo' ) );
					$order    = wc_get_order( $order_id );

					if ( ! is_a( $order, 'WC_Abstract_Order' ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '2002' );
					}

					if ( 'on-hold' != $order->get_status() ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '2003' );
					}

					if ( $order->get_total() != pafw_get_unslash( $_POST, 'trdAmt' ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '2005' );
					}

					$transaction_id = pafw_get_unslash( $_POST, 'trdNo' );
					if ( empty( $transaction_id ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '2006' );
					}

					$hash_data = array(
						pafw_get_unslash( $_POST, 'outStatCd' ),
						pafw_get_unslash( $_POST, 'trdDtm' ),
						$this->get_merchant_id(),
						$this->get_txnid( $order ),
						$order->get_total(),
						pafw_get( $this->settings, 'license_key' )
					);

					if ( pafw_get_unslash( $_POST, 'pktHash' ) != hash( 'sha256', implode( '', $hash_data ) ) ) {
						throw new Exception( __( '잘못된 요청입니다.', 'pgall-for-woocommerce' ), '3001' );
					}

					$order->update_meta_data( '_pafw_vbank_noti_received', 'yes' );
					$order->update_meta_data( '_pafw_vbank_noti_transaction_date', pafw_get_unslash( $_POST, 'trdDtm' ) );
					$order->update_meta_data( '_pafw_vbank_noti_deposit_bank', pafw_get_unslash( $_POST, 'bankNm' ) );
					$order->update_meta_data( '_pafw_vbank_noti_depositor', pafw_get_unslash( $_POST, 'dpstrNm' ) );
					$order->save_meta_data();

					$this->add_payment_log( $order, '[ 가상계좌 입금 완료 ]', array(
						'거래번호' => $transaction_id
					) );

					$order->payment_complete( $transaction_id );

					do_action( 'pafw_payment_action', 'completed', $order->get_total(), $order, $this );

					if ( pafw_order_need_shipping( $order ) ) {
						$order->update_status( $this->settings['order_status_after_payment'] );
					}

					$order->set_date_paid( current_time( 'timestamp', true ) );
					$order->save();

					echo 'OK';
				} catch ( Exception $e ) {
					// translators: 1: error code, 2: error message
					$this->add_log( sprintf( __( '가상계좌 입금통보 처리 오류 : [PAFW-ERR-%1$s] %2$s', 'pgall-for-woocommerce' ), $e->getCode(), $e->getMessage() ) );
				}
				die();
			}
		}
	}

}
