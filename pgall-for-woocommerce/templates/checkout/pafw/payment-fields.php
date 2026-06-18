<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$is_personal_payment = 'yes' == $params['personal_payment'];
?>

<div class='pafw-billing-fields'>
    <input type="hidden" name="_pafw_uid" value="<?php echo esc_attr( $params['uid'] ); ?>">
    <input type="hidden" name="need_shipping" value="<?php echo esc_attr( $params['need_shipping'] ); ?>">
    <input type="hidden" name="include_tax" value="<?php echo esc_attr( $params['include_tax'] ); ?>">

	<?php if ( ! empty( $params['product_id'] ) ) : ?>
        <input type="hidden" name="product_id" value="<?php echo esc_attr( $params['product_id'] ); ?>">
        <input type="hidden" name="variation_id" value="<?php echo esc_attr( $params['variation_id'] ); ?>">
        <input type="hidden" name="variation" value="<?php echo esc_attr( $params['variation'] ); ?>">
        <input type="hidden" name="cart_item_data" value="<?php echo esc_attr( $params['cart_item_data'] ); ?>">
        <input type="hidden" name="order_received_url" value="<?php echo esc_attr( $params['order_received_url'] ); ?>">
	<?php else: ?>
		<?php if ( $is_personal_payment ) : ?>
            <p class="form-row form-row-wide mshop_addr_title mshop-enable-kr" id="order_title_field">
                <label for="order_title" class=""><?php echo esc_attr( $params['personal_payment_title_label'] ); ?>&nbsp;<abbr class="required" title="required">*</abbr></label>
                <span class="woocommerce-input-wrapper">
                        <input type="text" class="input-text " name="order_title" id="order_title" placeholder="<?php echo esc_attr( $params['personal_payment_title_placeholder'] ); ?>" value="<?php echo esc_attr( $params['order_title'] ); ?>">
                    </span>
            </p>
            <p class="form-row form-row-wide mshop_addr_title mshop-enable-kr" id="order_amount_field">
                <label for="order_amount" class=""><?php echo esc_attr( $params['personal_payment_price_label'] ); ?>&nbsp;<abbr class="required" title="required">*</abbr></label>
                <span class="woocommerce-input-wrapper">
                        <input type="text" class="input-text " name="order_amount" id="order_amount" autocomplete="nope" placeholder="<?php echo esc_attr( $params['personal_payment_price_placeholder'] ); ?>" value="<?php echo esc_attr( $params['order_amount'] ); ?>">
                    </span>
            </p>
		<?php else: ?>
            <input type="hidden" name="order_title" value="<?php echo esc_attr( $params['order_title'] ); ?>">
            <input type="hidden" name="order_amount" value="<?php echo esc_attr( $params['order_amount'] ); ?>">
		<?php endif; ?>
	<?php endif; ?>
    <input type="hidden" name="quantity" value="<?php echo esc_attr( $params['quantity'] ); ?>">
</div>