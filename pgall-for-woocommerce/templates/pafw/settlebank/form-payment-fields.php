<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$uid = uniqid( 'pafw_settlebank_' );

?>
<div class="settlebank-payment-fields">
	<?php echo esc_html( $gateway->get_description() ); ?>
</div>
