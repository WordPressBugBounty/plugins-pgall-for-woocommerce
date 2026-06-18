<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$who_exchange_return = new WP_User( $exchange_return->post->post_author );
?>
<tr class="refund <?php echo ( ! empty( $class ) ) ? esc_attr( $class ) : ''; ?>" data-order_refund_id="<?php echo esc_attr( $exchange_return->get_id() ); ?>">
    <td class="ex-type">
		<?php
		if ( $exchange_return->is_exchange() ) {
			$type = esc_attr__( '교환신청', 'pgall-for-woocommerce' );
		} else {
			$type = esc_attr__( '반품신청', 'pgall-for-woocommerce' );
		}
		// translators: 1: request type, 2: request id
		echo sprintf( '<span class="ex-type">%s <span class="ex-id">(#%s)</span></span>', esc_html( $type ), absint( $exchange_return->get_id() ) );
		// translators: %s: request datetime
		echo sprintf( '<br><span class="ex-time">%s</span>', esc_html( date_i18n( 'Y-m-d H:i', strtotime( $exchange_return->post->post_date ) ) ) );
		?>
    </td>
    <td class="ex-items">
		<?php
		foreach ( $exchange_return->get_items() as $key => $item ) {
			$product_id      = ! empty( $item[ 'variation_id' ] ) ? $item[ 'variation_id' ] : $item[ 'product_id' ];
			$product         = wc_get_product( $product_id );
			$order_item_meta = wc_display_item_meta( $item, array( 'before' => '', 'after' => '', 'echo' => false, 'label_before' => '', 'label_after' => '' ) );

			echo '<div class="exchange-return-items">';
			printf( '<a href="%s">%1s</a> x %2s개', esc_url( get_permalink( $product->get_id() ) ), esc_html( $product->get_title() ), absint( $item[ 'qty' ] ) );
			if ( ! empty( $order_item_meta ) ) {
				printf( '<br><span class="item_meta">%s</span>', esc_html( $order_item_meta ) );
			}
			echo '</div>';
		}
		?>
    </td>
    <td class="ex-reason">
		<?php if ( $exchange_return->get_reason() ) : ?>
            <p class="exchange-return-requests"><?php /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ echo str_replace( "\n", "<br>", $exchange_return->get_reason() ); ?></p>
		<?php endif; ?>
        <input type="hidden" class="order_refund_id" name="order_refund_id[]" value="<?php echo esc_attr( $exchange_return->get_id() ); ?>"/>
    </td>
    <td class="ex-status">
		<?php echo 'processing' == $exchange_return->get_status() ? esc_html__( '요청', 'pgall-for-woocommerce' ) : esc_html__( '완료', 'pgall-for-woocommerce' ); ?>
    </td>

	<?php do_action( 'woocommerce_admin_order_item_values', null, $exchange_return, absint( $exchange_return->get_id() ) ); ?>
</tr>
