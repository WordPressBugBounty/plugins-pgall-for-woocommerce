<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<tr class="refund <?php echo ( ! empty( $class ) ) ? esc_attr( $class ) : ''; ?>" data-order_refund_id="<?php echo esc_attr( $exchange_return->get_id() ); ?>">
    <td class="thumb pafw-ex-thumb <?php echo esc_attr( $exchange_return->get_status() ); ?>">
        <div></div>
    </td>

    <td class="name" colspan="3">
		<?php
		if ( $exchange_return->is_exchange() ) {
			$type = esc_attr__( '교환신청', 'pgall-for-woocommerce' );
		} else {
			$type = esc_attr__( '반품신청', 'pgall-for-woocommerce' );
		}

		echo esc_html( $type . ' #' . absint( $exchange_return->get_id() ) . ' - ' . esc_attr( date_i18n( get_option( 'date_format' ) . ', ' . get_option( 'time_format' ), $exchange_return->get_date_created()->getOffsetTimestamp() ) ) );

		if ( $exchange_return->get_customer_id() > 0 ) {
			$who_exchange_return = get_userdata( $exchange_return->get_customer_id() );
			echo ' ' . esc_attr_x( 'by', 'Ex: Refund - $date >by< $username', 'pgall-for-woocommerce' ) . ' ' . '<abbr class="refund_by" title="' . esc_attr__( 'ID: ', 'pgall-for-woocommerce' ) . absint( $who_exchange_return->ID ) . '">' . esc_attr( $who_exchange_return->display_name ) . '</abbr>';
		} else {
			echo ' ' . esc_attr_x( 'by', 'Ex: Refund - $date >by< $username', 'pgall-for-woocommerce' ) . ' ' . '<abbr class="refund_by" title="' . esc_attr__( 'ID: ', 'pgall-for-woocommerce' ) . absint( 0 ) . '">' . esc_attr( 'guest' ) . '</abbr>';
		}
		?>
        <table class="exchange-return-items">
            <thead>
            <tr>
                <th><?php $exchange_return->is_exchange() ? esc_html_e( "교환 신청 상품", "pgall-for-woocommerce" ) : esc_html_e( "반품 신청 상품", "pgall-for-woocommerce" ); ?></th>
				<?php if ( $exchange_return->is_exchange() ) : ?>
                    <th><?php esc_html_e( "교환 희망 상품", "pgall-for-woocommerce" ); ?></th>
				<?php endif; ?>
            </tr>
            </thead>
            <tbody>
			<?php
			foreach ( $exchange_return->get_items() as $key => $item ) {
				$order_item_meta  = wc_display_item_meta( $item, array( 'before' => '', 'after' => '', 'echo' => false, 'label_before' => '', 'label_after' => '' ) );
				$exchange_product = wc_get_product( $item->get_meta( '_exchange_product_id' ) );

				?>

                <tr>
                    <td>
						<?php
						// translators: 1 : url of product, 2: product name, 3: quantity
						printf( '<a href="%1$s">%2$s</a> x %3$s개', esc_url( get_edit_post_link( $item->get_product_id() ) ), esc_html( $item->get_name() ), esc_html( $item->get_quantity() ) );
						if ( ! empty( $order_item_meta ) ) {
							printf( '<br><span class="item_meta">%s</span>', esc_html( $order_item_meta ) );
						}
						?>
                    </td>
					<?php if ( $exchange_return->is_exchange() ) : ?>
                        <td>
							<?php if ( $exchange_product ) : ?>
								<?php /* translators: 1: url of product, 2: product name */
								printf( '<a href="%1$s">%2$s</a>', esc_url( get_edit_post_link( $exchange_product->get_id() ) ), esc_html( $exchange_product->get_name() ) ); ?>
							<?php endif; ?>
                        </td>
					<?php endif; ?>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>

		<?php if ( $exchange_return->get_reason() ) : ?>
            <p class="exchange-return-requests"><?php echo esc_html( str_replace( "\n", "<br>", $exchange_return->get_reason() ) ); ?></p>
		<?php endif; ?>
        <input type="hidden" class="order_refund_id" name="order_refund_id[]" value="<?php echo esc_attr( $exchange_return->get_id() ); ?>"/>
    </td>

	<?php do_action( 'woocommerce_admin_order_item_values', null, $exchange_return, absint( $exchange_return->get_id() ) ); ?>

    <td class="pafw-actions">
		<?php
		$order_id = $exchange_return->get_parent_id();

		$order = wc_get_order( $order_id );

		if ( 'processing' == $exchange_return->get_status() && in_array( $order->get_status(), array( 'accept-exchange', 'accept-return' ) ) ) {
			$items = array();

			foreach ( $exchange_return->get_items() as $key => $item ) {
				$items[] = array(
					'item_id' => $item->get_meta( '_exchange_return_item_id' ),
					'qty'     => $item->get_quantity()
				);
			}

			if ( 'exchange' == $exchange_return->get_ex_type() ) {
				echo '<a href="#" data-items="' . esc_attr( json_encode( $items ) ) . '" class="apply-exchange button">' . esc_html__( '교환처리', 'pgall-for-woocommerce' ) . '</a>';
			} else {
				echo '<a href="#" data-items="' . esc_attr( json_encode( $items ) ) . '" class="apply-return button">' . esc_html__( '반품처리', 'pgall-for-woocommerce' ) . '</a>';
			}
		}
		?>
    </td>
    <td class="wc-order-edit-line-item">
        <div class="wc-order-edit-line-item-actions">
            <a class="delete_refund" href="#"></a>
        </div>
    </td>
</tr>
