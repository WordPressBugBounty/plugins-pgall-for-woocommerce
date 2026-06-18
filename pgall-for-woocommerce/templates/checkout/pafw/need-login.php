<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="pafw-instant-payment-wrapper need-login">
    <a href="<?php echo esc_url( wp_login_url( pafw_get_unslash( $_SERVER, 'REQUEST_URI' ) ) ); ?>" class="button button-primary"><?php esc_html_e( '로그인  후 결제를 진행 해 주세요.', 'pgall-for-woocommerce' ); ?></a>
</div>
