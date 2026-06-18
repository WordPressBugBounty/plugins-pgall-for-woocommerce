<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'pafw-before-exchange-return-type' ); ?>

<?php if ( PAFW_Exchange_Return_Manager::support_exchange() && PAFW_Exchange_Return_Manager::support_return() ) : ?>
    <div class="field pafw-ex-type">
        <label><?php esc_html_e( '신청 유형을 선택하세요.', 'pgall-for-woocommerce' ); ?></label>
        <div id="pafw_type_container">
            <div class="return_wrap">
                <input type="radio" name="type" value="return" checked>
                <label><img src="<?php echo esc_url( PAFW()->plugin_url() . '/assets/images/m_icon_check.png' ); ?>"><?php esc_html_e( '반품', 'pgall-for-woocommerce' ); ?></label>
            </div>
            <div class="exchange_wrap">
                <input type="radio" name="type" value="exchange">
                <label><img src="<?php echo esc_url( PAFW()->plugin_url() . '/assets/images/m_icon_check.png' ); ?>"><?php esc_html_e( '교환', 'pgall-for-woocommerce' ); ?></label>
            </div>
        </div>
    </div>
<?php elseif ( PAFW_Exchange_Return_Manager::support_exchange() ) : ?>
    <div class="field pafw-ex-type" style="display: none;">
        <div id="pafw_type_container">
            <div class="exchange_wrap">
                <input type="radio" name="type" value="exchange" checked="checked">
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="field pafw-ex-type" style="display: none;">
        <div id="pafw_type_container">
            <div class="return_wrap">
                <input type="radio" name="type" value="return" checked="checked">
            </div>
        </div>
    </div>
<?php endif; ?>

<?php do_action( 'pafw-after-exchange-return-type' ); ?>

