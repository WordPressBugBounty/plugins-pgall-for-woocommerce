<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

defined( 'ABSPATH' ) || exit;
?>

<p class="order-again">
	<a href="<?php echo esc_url( $order_again_url ); ?>" class="button"><?php esc_html_e( '교환/반품', 'pgall-for-woocommerce' ); ?></a>
</p>
