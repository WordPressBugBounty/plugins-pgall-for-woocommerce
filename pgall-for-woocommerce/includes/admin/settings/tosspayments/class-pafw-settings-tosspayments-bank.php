<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PAFW_Settings_TossPayments_Bank' ) ) {

	class PAFW_Settings_TossPayments_Bank extends PAFW_Settings_TossPayments {

		function get_setting_fields() {
			return array(
				array(
					'type'     => 'Section',
					'title'    => __( '퀵계좌이체 설정', 'pgall-for-woocommerce' ),
					'elements' => array(
						array(
							'id'        => 'tosspayments_bank_title',
							'title'     => __( '결제수단 이름', 'pgall-for-woocommerce' ),
							'className' => 'fluid',
							'type'      => 'Text',
							'default'   => __( '퀵계좌이체', 'pgall-for-woocommerce' ),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '결제 페이지에서 구매자들이 결제 진행 시 선택하는 결제수단명 입니다.', 'pgall-for-woocommerce' )
								)
							)
						),
						array(
							'id'        => 'tosspayments_bank_description',
							'title'     => __( '결제수단 설명', 'pgall-for-woocommerce' ),
							'className' => 'fluid',
							'type'      => 'TextArea',
							'default'   => __( '계좌에서 바로 결제하는 퀵계좌이체 입니다.', 'pgall-for-woocommerce' ),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '결제 페이지에서 구매자들이 결제 진행 시 제공되는 결제수단 상세설명 입니다.', 'pgall-for-woocommerce' )
								)
							)
						),
						array(
							'id'        => 'tosspayments_bank_receipt',
							'title'     => __( '현금 영수증', 'pgall-for-woocommerce' ),
							'className' => '',
							'type'      => 'Toggle',
							'default'   => 'no',
							'tooltip'   => array(
								'title' => array(
									'content' => __( '현금 영수증 발행 여부를 설정 할 수 있습니다. 현금 영수증 발행은 결제 대행사와 별도 계약이 되어 있어야 이용이 가능합니다.', 'pgall-for-woocommerce' ),
								)
							)
						),
					)
				),
				array(
					'type'     => 'Section',
					'title'    => __( '퀵계좌이체 고급 설정', 'pgall-for-woocommerce' ),
					'elements' => array(
						array(
							'id'        => 'tosspayments_bank_use_advanced_setting',
							'title'     => '사용',
							'className' => '',
							'type'      => 'Toggle',
							'default'   => 'no',
							'tooltip'   => array(
								'title' => array(
									'content' => __( '고급 설정 사용 시, 기본 설정에 우선합니다.', 'pgall-for-woocommerce' ),
								)
							)
						),
						array(
							'id'        => 'tosspayments_bank_order_status_after_payment',
							'title'     => __( '결제완료시 변경될 주문상태', 'pgall-for-woocommerce' ),
							'showIf'    => array( 'tosspayments_bank_use_advanced_setting' => 'yes' ),
							'className' => '',
							'type'      => 'Select',
							'default'   => 'processing',
							'options'   => $this->filter_order_statuses( array(
								'cancelled',
								'failed',
								'on-hold',
								'refunded'
							) ),
						),
						array(
							'id'        => 'tosspayments_bank_possible_refund_status_for_mypage',
							'title'     => __( '구매자 주문취소 가능상태', 'pgall-for-woocommerce' ),
							'showIf'    => array( 'tosspayments_bank_use_advanced_setting' => 'yes' ),
							'className' => '',
							'type'      => 'Select',
							'default'   => 'pending,on-hold',
							'multiple'  => true,
							'options'   => $this->get_order_statuses(),
						)
					)
				)
			);
		}
	}
}
