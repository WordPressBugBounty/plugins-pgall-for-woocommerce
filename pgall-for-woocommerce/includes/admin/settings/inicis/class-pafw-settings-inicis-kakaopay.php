<?php

//소스에 URL로 직접 접근 방지
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PAFW_Settings_Inicis_KakaoPay' ) ) {
	class PAFW_Settings_Inicis_KakaoPay extends PAFW_Settings_Inicis {
		function get_setting_fields() {
			return array(
				array(
					'type'     => 'Section',
					'title'    => '삼성페이 설정',
					'elements' => array(
						array(
							'id'        => 'inicis_kakaopay_title',
							'title'     => '결제수단 이름',
							'className' => 'fluid',
							'type'      => 'Text',
							'default'   => __( "카카오페이", "pgall-for-woocommerce" ),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '결제 페이지에서 구매자들이 결제 진행 시 선택하는 결제수단명 입니다.', 'pgall-for-woocommerce' )
								)
							)
						),
						array(
							'id'        => 'inicis_kakaopay_description',
							'title'     => '결제수단 설명',
							'className' => 'fluid',
							'type'      => 'TextArea',
							'default'   => __( '카카오페이로 결제합니다.', 'pgall-for-woocommerce' ),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '결제 페이지에서 구매자들이 결제 진행 시 제공되는 결제수단 상세설명 입니다.', 'pgall-for-woocommerce' )
								)
							)
						),
					)
				),
				array(
					'type'     => 'Section',
					'title'    => __( "카카오페이 고급 설정", "pgall-for-woocommerce" ),
					'elements' => array(
						array(
							'id'        => 'inicis_kakaopay_use_advanced_setting',
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
							'id'        => 'inicis_kakaopay_order_status_after_payment',
							'title'     => __( '결제완료시 변경될 주문상태', 'pgall-for-woocommerce' ),
							'showIf'    => array( 'inicis_kakaopay_use_advanced_setting' => 'yes' ),
							'className' => '',
							'type'      => 'Select',
							'default'   => 'processing',
							'options'   => $this->filter_order_statuses( array(
								'cancelled',
								'failed',
								'on-hold',
								'refunded'
							) ),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '삼성페이 결제건에 한해서, 결제(입금)이 완료되면 지정된 주문상태로 변경합니다.', 'pgall-for-woocommerce' ),
								)
							)
						),
						array(
							'id'        => 'inicis_kakaopay_possible_refund_status_for_mypage',
							'title'     => __( '구매자 주문취소 가능상태', 'pgall-for-woocommerce' ),
							'showIf'    => array( 'inicis_kakaopay_use_advanced_setting' => 'yes' ),
							'className' => '',
							'type'      => 'Select',
							'default'   => 'pending,on-hold',
							'multiple'  => true,
							'options'   => $this->get_order_statuses(),
							'tooltip'   => array(
								'title' => array(
									'content' => __( '삼성페이 결제건에 한해서, 구매자가 내계정 페이지에서 주문취소 요청을 할 수 있는 주문 상태를 지정합니다.', 'pgall-for-woocommerce' ),
								)
							)
						)
					)
				)
			);
		}
	}
}