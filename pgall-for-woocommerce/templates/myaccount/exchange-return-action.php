<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'pafw-before-exchange-return-action' ); ?>

<div class="field pafw-ex-action">
    <input type="hidden" name="order_id" value="<?php echo esc_attr( $order_id ); ?>">
    <input type="button" class="request-exchange-return" value="<?php esc_attr_e( '신청하기', 'pgall-for-woocommerce' ); ?>">
</div>

<?php do_action( 'pafw-after-exchange-return-action' ); ?>
