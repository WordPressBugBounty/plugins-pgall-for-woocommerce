<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

?>

<?php if ( ! empty( $payment_data ) ) : ?>
	<?php foreach ( $payment_data as $payment_data_row ) : ?>
        <div class="pafw_payment_info">
            <h4><?php echo esc_html( $payment_data_row[ 'title' ] ); ?></h4>
			<?php foreach ( $payment_data_row[ 'data' ] as $label => $desc ) : ?>
                <p><?php printf( '%s : %s', esc_html( $label ), esc_html( $desc ) ); ?></p>
			<?php endforeach; ?>
        </div>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ( ! empty( $cancel_data ) ) : ?>
    <div class="pafw_cancel_info">
        <h4><?php esc_html_e( '취소정보', 'pgall-for-woocommerce' ); ?></h4>
		<?php foreach ( $cancel_data as $label => $desc ) : ?>
            <p><?php printf( '%s : %s', esc_html( $label ), esc_html( $desc ) ); ?></p>
		<?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="pafw_button_wrapper">
    <input type="button" class="button pafw_action_button tips" id="pafw-refund-request" name="refund-request" data-tip="<?php esc_attr_e( '전체취소', 'pgall-for-woocommerce' ); ?>" value="<?php esc_attr_e( '전체취소', 'pgall-for-woocommerce' ); ?>" <?php echo $is_refundable && $is_fully_refundable ? '' : 'disabled'; ?>>
	<?php if ( ! empty( $tid ) ) : ?>
        <input type="button" class="button pafw_action_button tips" id="pafw-check-receipt" name="refund-request-check-receipt" data-tip="<?php esc_attr_e( '영수증 확인', 'pgall-for-woocommerce' ); ?>" value="<?php esc_attr_e( '영수증 확인', 'pgall-for-woocommerce' ); ?>">
	<?php endif; ?>
</div>
