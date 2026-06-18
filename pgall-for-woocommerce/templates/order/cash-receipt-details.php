<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$receipt_request = PAFW_Cash_Receipt::get_receipt_request( $order->get_id() );

if ( empty( $receipt_request ) ) {
	return;
}

$cash_receipt_number = $order->get_meta( '_pafw_bacs_receipt_receipt_number' );
$transaction_id      = $order->get_meta( '_pafw_bacs_receipt_tid' );

?>

<div class="pafw-payment-details-section">
    <h2><?php esc_html_e( '현금영수증', 'pgall-for-woocommerce' ); ?></h2>

    <table class="pafw-payment-details woocommerce-table woocommerce-table--order-details shop_table order_details">
        <thead>
        <tr>
            <th class="woocommerce-table__ex-table usage"><?php esc_html_e( '용도', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table reg_number"><?php esc_html_e( '발행정보', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table status"><?php esc_html_e( '상태', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table reg_number"><?php esc_html_e( '현금영수증번호', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table status"><?php esc_html_e( '일자', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table action"><?php esc_html_e( '비고', 'pgall-for-woocommerce' ); ?></th>
            <th class="woocommerce-table__ex-table"></th>
        </tr>
        </thead>
        <tr>
            <td><?php echo esc_html( PAFW_Cash_Receipt::get_usage_label( $order->get_meta( '_pafw_bacs_receipt_usage' ) ) ) ?></td>
            <td><?php echo esc_html( $order->get_meta( '_pafw_bacs_receipt_reg_number' ) ) ?></td>
            <td><?php echo esc_html( PAFW_Cash_Receipt::get_status_name( $receipt_request[ 'status' ] ) ); ?></td>
            <td>
				<?php echo esc_html( $cash_receipt_number ); ?>
            </td>
            <td><?php
				$issue_date = $order->get_meta( '_pafw_bacs_receipt_issue_date' );
				if ( ! empty( $issue_date ) ) {
					echo esc_html( date( 'Y-m-d', strtotime( $issue_date ) ) );
				}
				?>
            <td><?php echo esc_html( $receipt_request[ 'message' ] ); ?></td>
            <td>
				<?php if ( ! empty( $transaction_id ) ) : ?>
                    <button data-order_id="<?php echo esc_attr( $order->get_id() ); ?>" class="button pafw-view-cash-receipt"><?php esc_html_e( '조회', 'pgall-for-woocommerce' ); ?></button>
				<?php endif; ?>
            </td>
        </tr>
    </table>
</div>