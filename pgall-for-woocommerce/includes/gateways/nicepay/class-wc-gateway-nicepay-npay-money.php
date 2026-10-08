<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Gateway_Nicepay_NPay_Money' ) ) :

	class WC_Gateway_Nicepay_NPay_Money extends WC_Gateway_Nicepay { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound

		public function __construct() {
			$this->id = 'nicepay_npay_money';

			parent::__construct();

			if ( empty( $this->settings['title'] ) ) {
				$this->title       = __( 'Npay 머니 결제', 'pgall-for-woocommerce' );
				$this->description = __( 'Npay 머니로 결제합니다.', 'pgall-for-woocommerce' );
			} else {
				$this->title       = $this->settings['title'];
				$this->description = $this->settings['description'];
			}

			$this->title       = str_replace( "네이버페이", "Npay", $this->title );
			$this->description = str_replace( "네이버페이", "Npay", $this->description );

			$this->supports[] = 'refunds';
		}
	}

endif;