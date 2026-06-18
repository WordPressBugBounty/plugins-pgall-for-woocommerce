<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
// phpcs:disable WordPress.Security.NonceVerification

defined( 'ABSPATH' ) || exit;

if ( ! WC()->cart->needs_payment() ) {
	return;
}

$selected_method_id = pafw_get_unslash( $_POST, 'payment_method' );
$is_saved_token     = pafw_get_unslash( $_POST, 'issavedtoken', 0 );
$token              = pafw_get_unslash( $_POST, 'token', 0 );
$payment_tokens     = array();
$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();

if ( is_user_logged_in() ) {
	$payment_tokens = WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );
	$payment_token  = WC_Payment_Tokens::get_customer_default_token( get_current_user_id() );
}


if ( empty( $selected_method_id ) ) {
	if ( ! empty( $payment_tokens ) ) {
		if ( empty( $payment_token ) || ! in_array( $payment_token->get_gateway_id(), array_keys( $available_gateways ) ) ) {
			$payment_token = current( $payment_tokens );
		}

		$selected_method_id = $payment_token->get_gateway_id();
		$token              = $payment_token->get_id();
		$is_saved_token     = 1;
	}
}

?>
<div id="payment-token" class="woocommerce-checkout-payment-token">
	<?php if ( ! empty( $payment_tokens ) ) : ?>
        <ul class="wc_payment_methods payment_methods methods">
			<?php foreach ( $payment_tokens as $payment_token ) : ?>
                <li class="payment-method token <?php echo $payment_token->get_id() == $token ? 'selected' : ''; ?>" data-token="<?php echo esc_attr( $payment_token->get_id() ); ?>" data-payment_method="<?php echo esc_attr( $payment_token->get_gateway_id() ); ?>" data-method_type="token">
                    <input id="payment_method_<?php echo esc_attr( $payment_token->get_id() ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $payment_token->get_gateway_id() ); ?>" <?php checked( $payment_token->get_id(), true ); ?>/>

                    <label for="payment_method_<?php echo esc_attr( $payment_token->get_id() ); ?>">
						<?php echo esc_html( $payment_token->get_display_name() ); ?>
                    </label>
                    <div class="payment_box payment_method_<?php echo esc_attr( $payment_token->get_id() ); ?>">
						<?php $payment_token->quota_field(); ?>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
        <input type="hidden" name="issavedtoken" value="<?php echo esc_attr( $is_saved_token ); ?>">
        <input type="hidden" name="token" value="<?php echo esc_attr( $token ); ?>">
        <h6><?php esc_html_e( "다른 결제수단 선택", "pgall-for-woocommerce" ); ?></h6>
	<?php endif; ?>
</div>