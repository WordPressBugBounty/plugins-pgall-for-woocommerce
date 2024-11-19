<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php esc_attr_e( $gateway->id ); ?>">
    <input id="payment_method_<?php esc_attr_e( $gateway->id ) . '_' . $uid; ?>" type="radio" class="input-radio" name="payment_method" value="<?php esc_attr_e( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php esc_attr_e( $gateway->order_button_text ); ?>"/>

    <label for="payment_method_<?php esc_attr_e( $gateway->id ) . '_' . $uid; ?>">
		<?php esc_attr_e( $gateway->get_title() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?><?php esc_attr_e( $gateway->get_icon() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
    </label>
    <div class="check"></div>
</li>

