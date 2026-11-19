<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PAFW_Settings_Kcp_Basic' ) ) {
	class PAFW_Settings_Kcp_Basic extends PAFW_Settings_Kcp {
		function get_setting_fields() {
			return array(
				array(
					'type'     => 'Section',
					'title'    => '기본 설정',
					'elements' => array(
						array(
							'id'       => 'pc_pay_method',
							'title'    => '결제수단',
							'default'  => 'kcp_card,kcp_bank,kcp_vbank',
							'type'     => 'Select',
							'multiple' => 'true',
							'options'  => WC_Gateway_PAFW_Kcp::get_supported_payment_methods()
						)
					)
				),
				array(
					'type'     => 'Section',
					'title'    => '운영 설정',
					'elements' => array(
						array(
							'id'        => 'operation_mode',
							'title'     => '운영 모드',
							'className' => '',
							'type'      => 'Select',
							'default'   => 'sandbox',
							'options'   => array(
								'sandbox'    => '개발 환경 (Sandbox)',
								'production' => '운영 환경 (Production)'
							)
						),
						array(
							'id'          => 'test_user_id',
							'title'       => '테스트 사용자 아이디',
							'className'   => 'fluid',
							'placeHolder' => '테스트 사용자 아이디를 선택하세요.',
							'showIf'      => array( 'operation_mode' => 'sandbox' ),
							'type'        => 'Text',
							'default'     => 'pgall_test_user',
							'desc2'       => __( '<div class="desc2">개발 환경 (Sandbox) 모드에서는 관리자 및 테스트 사용자에게만 결제수단이 노출됩니다.</div>', 'pgall-for-woocommerce' ),  // phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings
						),
						array(
							'id'        => 'site_cd',
							'title'     => '사이트코드',
							'className' => 'fluid',
							'default'   => self::$sandbox[ 'site_cd' ],
							'type'      => 'Text',
							// translators: %s: site code
							'desc2'     => sprintf( __( '<div class="desc2">결제 테스트용 사이트코드는 <code>%s</code>입니다.<br>실 결제용 사이트코드는 <code>CO</code> 또는 <code>CM</code>으로 시작해야 합니다.</div>', 'pgall-for-woocommerce' ), self::$sandbox[ 'site_cd' ] ),  // phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings
						),
						array(
							'id'        => 'site_key',
							'title'     => '사이트키',
							'className' => 'fluid',
							'default'   => self::$sandbox[ 'site_key' ],
							'type'      => 'Text',
							// translators: %s: site key
							'desc2'     => sprintf( __( '<div class="desc2">결제 테스트용 사이트키는 <code>%s</code>입니다.</div>', 'pgall-for-woocommerce' ), self::$sandbox[ 'site_key' ] )  // phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings
						),
						array(
							'id'        => 'webhook_verify_key',
							'title'     => '웹훅 검증키',
							'className' => 'fluid',
							'default'   => '',
							'type'      => 'Text',
							'desc2'     => __( '<div class="desc2">가상계좌 입금통보의 위변조 검증을 위해 사용을 권장합니다. KCP 파트너관리자 → 기술관리센터 → 웹훅(Webhook)관리에서 웹훅URL 설정(new)에 동의하고 발급받은 검증키를 입력하세요. 사이트키와 다른 키입니다.<br>키를 설정한 경우에만 가상계좌 입금통보의 해시를 검증하며, 해시가 누락되거나 일치하지 않으면 처리하지 않습니다. 미설정 시에는 기존 IP 및 주문정보 검사를 적용합니다.</div>', 'pgall-for-woocommerce' ), // phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings
						)
					)
				)
			);
		}
	}
}
