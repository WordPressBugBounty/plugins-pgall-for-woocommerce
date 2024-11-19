<?php
$is_personal_payment = 'yes' == $params['personal_payment'];
?>

<div class='pafw-billing-fields'>
    <input type="hidden" name="_pafw_uid" value="<?php esc_attr_e( $params['uid'] ); ?>">
    <input type="hidden" name="need_shipping" value="<?php esc_attr_e( $params['need_shipping'] ); ?>">
    <input type="hidden" name="include_tax" value="<?php esc_attr_e( $params['include_tax'] ); ?>">

	<?php if ( ! empty( $params['product_id'] ) ) : ?>
        <input type="hidden" name="product_id" value="<?php esc_attr_e( $params['product_id'] ); ?>">
        <input type="hidden" name="variation_id" value="<?php esc_attr_e( $params['variation_id'] ); ?>">
        <input type="hidden" name="variation" value="<?php esc_attr_e( $params['variation'] ); ?>">
        <input type="hidden" name="cart_item_data" value="<?php esc_attr_e( $params['cart_item_data'] ); ?>">
        <input type="hidden" name="order_received_url" value="<?php esc_attr_e( $params['order_received_url'] ); ?>">
	<?php else: ?>
		<?php if ( $is_personal_payment ) : ?>
            <p class="form-row form-row-wide mshop_addr_title mshop-enable-kr" id="order_title_field">
                <label for="order_title" class=""><?php esc_attr_e( $params['personal_payment_title_label'] ); ?>&nbsp;<abbr class="required" title="required">*</abbr></label>
                <span class="woocommerce-input-wrapper">
                        <input type="text" class="input-text " name="order_title" id="order_title" placeholder="<?php esc_attr_e( $params['personal_payment_title_placeholder'] ); ?>" value="<?php esc_attr_e( $params['order_title'] ); ?>">
                    </span>
            </p>
            <p class="form-row form-row-wide mshop_addr_title mshop-enable-kr" id="order_amount_field">
                <label for="order_amount" class=""><?php esc_attr_e( $params['personal_payment_price_label'] ); ?>&nbsp;<abbr class="required" title="required">*</abbr></label>
                <span class="woocommerce-input-wrapper">
                        <input type="text" class="input-text " name="order_amount" id="order_amount" autocomplete="nope" placeholder="<?php esc_attr_e( $params['personal_payment_price_placeholder'] ); ?>" value="<?php esc_attr_e( $params['order_amount'] ); ?>">
                    </span>
            </p>
		<?php else: ?>
            <input type="hidden" name="order_title" value="<?php esc_attr_e( $params['order_title'] ); ?>">
            <input type="hidden" name="order_amount" value="<?php esc_attr_e( $params['order_amount'] ); ?>">
		<?php endif; ?>
	<?php endif; ?>
    <input type="hidden" name="quantity" value="<?php esc_attr_e( $params['quantity'] ); ?>">
</div>