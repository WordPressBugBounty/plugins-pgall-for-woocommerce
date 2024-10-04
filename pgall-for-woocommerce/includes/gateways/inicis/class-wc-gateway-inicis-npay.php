<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Gateway_Inicis_NPay' ) ) {
	return;
}

class WC_Gateway_Inicis_NPay extends WC_Gateway_Inicis {

	public function __construct() {
		$this->id = 'inicis_npay';

		parent::__construct();

		if ( empty( $this->settings['title'] ) ) {
			$this->title       = __( '네이버페이 결제', 'pgall-for-woocommerce' );
			$this->description = __( '네이버페이로 결제합니다.', 'pgall-for-woocommerce' );
		} else {
			$this->title       = $this->settings['title'];
			$this->description = $this->settings['description'];
		}

		$this->supports[] = 'refunds';
	}
	public function get_accept_methods() {
		$accept_methods = parent::get_accept_methods();

		if ( wp_is_mobile() ) {
			$accept_methods[] = 'twotrs_isp=Y';
			$accept_methods[] = 'block_isp=Y';
			$accept_methods[] = 'd_npay=Y';
			$accept_methods[] = 'twotrs_isp_noti=N';
			$accept_methods[] = 'apprun_check=Y';
			$accept_methods[] = 'extension_enable=Y';
		} else {
			$accept_methods[] = 'cardonly';
		}

		return $accept_methods;
	}
	public function process_approval_response( $order, $response ) {
		$order->update_meta_data( "_pafw_card_num", pafw_get( $response, 'card_num' ) );
		$order->update_meta_data( "_pafw_card_code", pafw_get( $response, 'card_code' ) );
		$order->update_meta_data( "_pafw_card_name", pafw_get( $response, 'card_name' ) );
		$order->save_meta_data();
		
		$this->add_payment_log( $order, '[ 결제 승인 완료 ]', array (
			'거래번호' => $response['transaction_id']
		) );
	}
}