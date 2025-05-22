<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<table class="sales-by-payment-gateway">
    <thead>
    <tr>
        <th><?php _e( "결제수단", "pgall-for-woocommerce" ); ?></th>
        <th><?php _e( "결제건수", "pgall-for-woocommerce" ); ?></th>
        <th><?php _e( "결제금액", "pgall-for-woocommerce" ); ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ( $results as $result ) : ?>
        <tr>
            <td class="payment_method"><?php echo $result[ 'payment_method_title' ]; ?></td>
            <td class="order_count"><?php echo number_format( intval( $result[ 'order_count' ] ) ); ?></td>
            <td class="order_total"><?php echo number_format( floatval( $result[ 'order_total' ] ), wc_get_price_decimals() ); ?></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>