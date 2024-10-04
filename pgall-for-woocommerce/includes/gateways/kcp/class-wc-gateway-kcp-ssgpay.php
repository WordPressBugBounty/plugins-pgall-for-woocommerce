<?php

//소스에 URL로 직접 접근 방지
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Gateway_Kcp_SSGPay' ) ) :

	class WC_Gateway_Kcp_SSGPay extends WC_Gateway_Kcp {

		public function __construct() {
			$this->id = 'kcp_ssgpay';

			parent::__construct();

			$this->settings['bills_cmd'] = 'card_bill';

			if ( empty( $this->settings['title'] ) ) {
				$this->title       = __( 'SSG Pay 결제', 'pgall-for-woocommerce' );
				$this->description = __( 'SSG Pay로 결제합니다.', 'pgall-for-woocommerce' );
			} else {
				$this->title       = $this->settings['title'];
				$this->description = $this->settings['description'];
			}

			$this->supports[] = 'refunds';
		}
	}

endif;