<?php

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>결제 완료</title>
</head>
<script type="text/javascript">
	<?php if( wp_is_mobile() ) : ?>
    location.href = '<?php echo esc_js( $redirect_url ); ?>';
	<?php else : ?>
    opener.location.href = '<?php echo esc_js( $redirect_url ); ?>';
    window.close();
	<?php endif; ?>
</script>
<body>
</body>
</html>
