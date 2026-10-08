<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Gateway_Nicepay_Tosspay_Money' ) ) :

	class WC_Gateway_Nicepay_Tosspay_Money extends WC_Gateway_Nicepay { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound

		public function __construct() {
			$this->id = 'nicepay_tosspay_money';

			parent::__construct();

			if ( empty( $this->settings['title'] ) ) {
				$this->title       = __( '토스페이 머니 결제', 'pgall-for-woocommerce' );
				$this->description = __( '토스페이 머니로 결제합니다.', 'pgall-for-woocommerce' );
			} else {
				$this->title       = $this->settings['title'];
				$this->description = $this->settings['description'];
			}

			$this->supports[] = 'refunds';
		}
	}

endif;