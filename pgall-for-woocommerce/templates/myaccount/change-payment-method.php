<?php
$gateway = pafw_get_payment_gateway_from_order( $subscription );

$token = null;

try {
	if ( ! $subscription->is_manual() ) {
		$token = PAFW_Token::get_token_for_order( $subscription );
	}
} catch ( Exception $e ) {

}

$customer_tokens = WC_Payment_Tokens::get_customer_tokens( $subscription->get_customer_id() );

?>

<tr>
    <td></td>
    <td class="pafw-payment-method">
        <input type="button" class="button pafw-show-payment-method-selector" value="<?php _e( "결제수단 변경", "pgall-for-woocommerce" ); ?>">
        <div class="pafw-payment-method-selector-wrapper" style="display: none;">
            <select id="pafw_token" name="pafw_token" style="width: 100%; font-size: 13px;">
                <option value="manual" <?php echo is_null( $token ) ? ' selected="selected"' : ''; ?>><?php _e( "수동 갱신", "pgall-for-woocommerce" ); ?></option>
				<?php foreach ( $customer_tokens as $customer_token ) : ?>
					<?php
					$selected = ! is_null( $token ) && $token->get_id() == $customer_token->get_id() ? ' selected="selected"' : '';
					?>
                    <option value="<?php echo $customer_token->get_id(); ?>" <?php echo $selected; ?>><?php echo $customer_token->get_display_name(); ?></option>
				<?php endforeach; ?>
            </select>
            <input type="button" class="button pafw-change-payment-method" value="<?php _e( "변경하기", "pgall-for-woocommerce" ); ?>">
        </div>
    </td>
</tr>