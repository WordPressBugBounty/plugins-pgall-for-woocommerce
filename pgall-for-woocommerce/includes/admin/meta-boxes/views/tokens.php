<?php
$gateway = pafw_get_payment_gateway_from_order( $order );

$token = null;

try {
	if ( ! $order->is_manual() ) {
		$token = PAFW_Token::get_token_for_order( $order );
	}
} catch ( Exception $e ) {

}

$customer_tokens = WC_Payment_Tokens::get_customer_tokens( $order->get_customer_id() );

?>

<div class="pafw_payment_info">
    <h4><?php _e( "결제수단", "pgall-for-woocommerce" ); ?></h4>
    <select id="pafw_token" name="pafw_token" style="width: 100%; font-size: 13px;">
        <option value="manual" <?php echo is_null( $token ) ? ' selected="selected"' : ''; ?>><?php _e( "수동 갱신", "pgall-for-woocommerce" ); ?></option>
		<?php foreach ( $customer_tokens as $customer_token ) : ?>
			<?php
			$selected = ! is_null( $token ) && $token->get_id() == $customer_token->get_id() ? ' selected="selected"' : '';
			?>
            <option value="<?php echo $customer_token->get_id(); ?>" <?php echo $selected; ?>><?php echo $customer_token->get_display_name(); ?></option>
		<?php endforeach; ?>
    </select>
	<?php if ( 'yes' == pafw_get( $gateway->settings, 'enable_quota', 'no' ) ) : ?>
        <h4><?php _e( "할부개월수", "pgall-for-woocommerce" ); ?></h4>
        <select id="pafw_card_quota" name="pafw_card_quota" style="width: 100%;">
			<?php
			$selected_quota = 0;
			$card_quota     = intval( $order->get_meta( 'pafw_card_quota_for_renewal' ) );
			$quotas         = explode( ',', pafw_get( $gateway->settings, 'quota' ) );
			if ( in_array( $card_quota, $quotas ) ) {
				$selected_quota = $card_quota;
			}
			?>
            <option value="00" <?php echo 0 == $selected_quota ? 'selected' : ''; ?>><?php _e( '일시불', 'pgall-for-woocommerce' ); ?></option>
			<?php foreach ( $quotas as $quota ) : ?>
                <option value="<?php echo sprintf( "%02d", $quota ); ?>" <?php echo $quota == $selected_quota ? 'selected' : ''; ?>><?php echo $quota . __( '개월', 'pgall-for-woocommerce' ); ?></option>
			<?php endforeach; ?>
        </select>
	<?php else: ?>
        <input type="hidden" id="pafw_card_quota" name="pafw_card_quota" value="00">
	<?php endif; ?>
</div>
