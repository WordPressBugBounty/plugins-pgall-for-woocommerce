<?php
// phpcs:disable WordPress.DateTime.RestrictedFunctions.date_date, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>

<p>
	<?php
    // translators: 1: payment method, 2: payment method title
	echo sprintf( __( '<div id="%1$s_thankyou_text"><p>%2$s로 결제되었습니다. 감사합니다.</p></div>', 'pgall-for-woocommerce' ), esc_html( $payment_method ), esc_html( $title ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
</p>
