<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

global $is_IE;

?>

<h2><?php esc_html_e( '에스크로 구매 확인', 'pgall-for-woocommerce' ); ?></h2>
<?php if ( 'yes' == $order->get_meta( '_pafw_escrow_order_confirm' ) ) : ?>
    <p><?php /* translators:%s: shipping company */
		printf( esc_html__( '배송업체 : %s', 'pgall-for-woocommerce' ), esc_html( $delivery_company_name ) ); ?></p>
    <p><?php /* translators:%s: tracking number */
		printf( esc_html__( '송장번호 : %s', 'pgall-for-woocommerce' ), esc_html( $delivery_shipping_num ) ); ?></p>
    <p class="order-info"><?php esc_html_e( '구매 확인이 완료되었습니다.', 'pgall-for-woocommerce' ); ?></p>
<?php else: ?>
    <p><?php /* translators:%s: shipping company */
		printf( esc_html__( '배송업체 : %s', 'pgall-for-woocommerce' ), esc_html( $delivery_company_name ) ); ?></p>
    <p><?php /* translators:%s: tracking number */
		printf( esc_html__( '송장번호 : %s', 'pgall-for-woocommerce' ), esc_html( $delivery_shipping_num ) ); ?></p>
    <p class="order-info"><?php esc_html_e( '배송 안내 메일이 발송되었습니다. 메일을 확인하신 후 구매 확인을 진행해주세요.', 'pgall-for-woocommerce' ); ?></p>
<?php endif; ?>
