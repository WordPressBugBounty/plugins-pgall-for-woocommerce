<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$quotas = explode( ',', pafw_get( $payment_gateway->settings, 'quota' ) );

?>

<?php if ( 'yes' == pafw_get( $payment_gateway->settings, 'enable_quota', 'no' ) ) : ?>
    <div class="pafw-card-info">
        <div class="fields-wrap">
            <select name="pafw_<?php echo esc_attr( $payment_gateway->get_master_id() ); ?>_card_quota">
                <option value="00"><?php esc_html_e( '일시불', 'pgall-for-woocommerce' ); ?></option>
				<?php foreach ( $quotas as $quota ) : ?>
                    <option value="<?php /* translators: %d: quota */ echo esc_attr( sprintf( "%02d", absint($quota) ) ); ?>"><?php echo sprintf( esc_html__( '%d개월', 'pgall-for-woocommerce' ), absint( $quota ) ); ?></option>
				<?php endforeach; ?>
            </select>
        </div>
    </div>
<?php else: ?>
    <input type="hidden" name="pafw_<?php echo esc_attr( $payment_gateway->get_master_id() ); ?>_card_quota" value="00">
<?php endif; ?>