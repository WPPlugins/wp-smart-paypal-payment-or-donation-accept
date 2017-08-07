<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
	$options = array(
		'wp_sppd_email'=>get_bloginfo('admin_email'),
		'wp_sppd_currency'=>'USD',
		'wp_sppd_type'=>'donation',
		'wp_sppd_title'=>'Buy me a cup of coffee?',
		'wp_sppd_desc'=>'WordPress Smart Paypal Payment or Donation Accept Plugin is an easy to use WordPress plugin to Accept Paypal payment for a service or a product or Donation in one click. Can be used in the sidebar, posts and pages.',
		'wp_sppd_amount'=>'20',
		'wp_sppd_payment_option_1'=>'Silver Service Plan',
		'wp_sppd_payment_option_price_1'=>'50',
		'wp_sppd_payment_option_2'=>'Gold Service Plan',
		'wp_sppd_payment_option_price_2'=>'100',
		'wp_sppd_payment_option_3'=>'Platinium Service Plan',
		'wp_sppd_payment_option_price_3'=>'200',		
		'wp_sppd_payment_option_4'=>'',
		'wp_sppd_payment_option_price_4'=>'',
		'wp_sppd_payment_option_5'=>'',
		'wp_sppd_payment_option_price_5'=>'',
		'wp_sppd_payment_option_6'=>'',
		'wp_sppd_payment_option_price_6'=>'',		
		'wp_sppd_payment_option_7'=>'',
		'wp_sppd_payment_option_price_7'=>'',
		'wp_sppd_payment_option_8'=>'',
		'wp_sppd_payment_option_price_8'=>'',
		'wp_sppd_payment_option_9'=>'',
		'wp_sppd_payment_option_price_9'=>'',		
		'wp_sppd_payment_option_10'=>'',
		'wp_sppd_payment_option_price_10'=>'',
		'wp_sppd_button'=>'btn_donate_cc.gif',
		'wp_sppd_button_url'=>'',
		'wp_sppd_returning_url'=>'',
		'wp_sppd_returning_url_cancel'=>''		
	);
	$currency = array(
		'USD'=>'US Dollar',
		'GBP'=>'Sterling Pound',
		'EUR'=>'Euro',
		'AUD'=>'Australian Dollar',
		'CAD'=>'Canadian Dollar',
		'NZD'=>'New Zealand Dollar',
	);
?>