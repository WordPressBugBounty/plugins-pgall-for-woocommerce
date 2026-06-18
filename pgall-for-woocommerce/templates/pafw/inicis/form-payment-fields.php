<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$uid = uniqid( 'pafw_inicis_' );

?>
<div class="inicis-payment-fields">
    <div class="payment-method-description" style="display: <?php echo empty( $bill_key ) ? 'block' : 'none'; ?>">
		<?php echo $gateway->get_description(); ?>
    </div>
</div>
