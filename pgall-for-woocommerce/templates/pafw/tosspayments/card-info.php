<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$master_id = $payment_gateway->get_master_id();

$bill_key = get_user_meta( get_current_user_id(), $payment_gateway->get_subscription_meta_key( 'bill_key' ), true );

?>

<div class="pafw-card pafw-<?php echo esc_attr( $master_id ); ?>">
	<?php if ( empty( $bill_key ) ) : ?>
        <div class="pafw-not-registered" data-payment_method="<?php echo esc_attr( $payment_gateway->id ); ?>"></div>
	<?php else: ?>
        <div class="pafw-registered">
			<?php
			$register_date  = get_user_meta( get_current_user_id(), $payment_gateway->get_subscription_meta_key( 'register_date' ), true );
			$card_num       = get_user_meta( get_current_user_id(), $payment_gateway->get_subscription_meta_key( 'card_num' ), true );
			$card_name      = get_user_meta( get_current_user_id(), $payment_gateway->get_subscription_meta_key( 'card_name' ), true );
			$card_bank_name = get_user_meta( get_current_user_id(), $payment_gateway->get_subscription_meta_key( 'card_bank_name' ), true );

			$card_num = substr_replace( $card_num, '00000000', 4, 8 );
			$card_num = implode( '-', str_split( $card_num, 4 ) );
			?>
            <div class="payment_method_type"></div>
            <div class="card_name"><?php echo esc_html( $card_name ); ?></div>
            <div class="card_num"><?php echo esc_html( $card_num ); ?></div>
			<?php if ( ! empty( $register_date ) ): ?>
                <div class="register_date"><?php /* translators:%s: registration date */  echo sprintf( esc_html__( "등록일 : %s", "pgall-for-woocommerce" ), esc_html( date( 'Y-m-d', strtotime( $register_date ) ) ) );; ?></div>
			<?php endif; ?>
        </div>
	<?php endif; ?>
</div>
