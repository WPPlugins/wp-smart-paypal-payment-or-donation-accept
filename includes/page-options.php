<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
	if(isset($_POST['submit'])) {
		check_admin_referer('wp_sppd_options');
		update_option('wp_sppd_email',$_POST['wp_sppd_email']);
		update_option('wp_sppd_currency',$_POST['wp_sppd_currency']);
		update_option('wp_sppd_type',$_POST['wp_sppd_type']);
		update_option('wp_sppd_amount',$_POST['wp_sppd_amount']);
		update_option('wp_sppd_title',$_POST['wp_sppd_title']);
		update_option('wp_sppd_desc',$_POST['wp_sppd_desc']);
		update_option('wp_sppd_button',$_POST['wp_sppd_button']);
		if($_POST['wp_sppd_button']!="customurl")
		{
			update_option('wp_sppd_button_url','');
		}
		else
		{
			update_option('wp_sppd_button_url',$_POST['wp_sppd_button_url']);
		}
		
		for($i=1; $i<11; $i++) {
			$opt = "wp_sppd_payment_option_".$i;
			$opt_price = "wp_sppd_payment_option_price_".$i;
			update_option("wp_sppd_payment_option_$i",$_POST[$opt]);
			update_option("wp_sppd_payment_option_price_$i",$_POST[$opt_price]);
		}		
		update_option('wp_sppd_returning_url',$_POST['wp_sppd_returning_url']);
		update_option('wp_sppd_returning_url_cancel',$_POST['wp_sppd_returning_url_cancel']);
		$error_found == FALSE;
		$success = __('WP Smart Paypal Payment or Donations options are successfully updated.', 'wp_sppd');
	}
	
 ?>
 <script type="text/javascript" src="<?php echo WP_PATH?>js/wp_sppd_script.js"></script>
<div class="wrap">
	<div style="background: none repeat scroll 0 0 #ECECEC;border: 1px solid #CFCFCF;color: #363636;margin: 10px 0 15px;padding:15px;text-shadow: 1px 1px #FFFFFF;">
    
    <fieldset class="options">
        <h3>Plugin Usage:</h3>
        <p>There are a few ways you can use this plugin:</p>
        <ol>
            <li>Add the shortcode <strong>[wp_sppd_payment]</strong> to a post or page</li>
            <li>Call the function from a template file: <strong>&lt;?php echo wp_sppd_payment(); ?&gt;</strong></li>
            <li>Use the <strong>Smart Paypal Payment</strong> Widget from the Widgets menu</li>   
        </ol>
    </fieldset>
    
    
    </div>
    
	<h2><?php _e('WP Smart Paypal Payment or Donation > Settings', 'wp_sppd'); ?></h2>
    
    <?php
    	if ($error_found == TRUE && isset($errors) == TRUE)
		{
	?>
    <div class="error fade">
        <p><strong><?php echo $errors; ?></strong></p>
    </div>
	<?php
	}
    if ($error_found == FALSE && strlen($success) > 0)
	{
	?>
	<div class="updated fade">
		<p><strong><?php echo $success; ?></strong></p>
	</div>
	<?php } ?>    
    
    <form action="" name="wp_sppd_options" id="wp_sppd_options" method="post">
    <table class="form-table">
        <tbody>
           <tr valign="top">
                <th scope="row"><label for="email"><?php _e('Paypal Email address', 'wp_sppd'); ?></label></th>
                <td>
                	<input name="wp_sppd_email" type="text" id="wp_sppd_email" value="<?php echo get_option('wp_sppd_email'); ?>" class="regular-text">
                </td>
            </tr>            
            <tr valign="top">
                <th scope="row"><label for="currency"><?php _e('Choose Payment Currency', 'wp_sppd'); ?></label></th>
                <td>
                	<select name="wp_sppd_currency" id="wp_sppd_currency" class="regular-text" style="width: 25em;">
                        <?php foreach(unserialize(currency) as $key => $values) { ?>
							<option value="<?php echo $key; ?>" <?php if(get_option('wp_sppd_currency')==$key) { ?> selected="selected" <?php } ?>><?php echo $values; ?></option>
                        <?php } ?>                                   
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="type"><?php _e('Payment Type', 'wp_sppd'); ?></label></th>
                <td>
                	<select name="wp_sppd_type" id="wp_sppd_type" class="regular-text" style="width: 25em;">
                        <option value="payments" <?php if(get_option('wp_sppd_type')=='payments') { ?> selected="selected" <?php } ?>>Service Payment</option>
                        <option value="donation" <?php if(get_option('wp_sppd_type')=='donation') { ?> selected="selected" <?php } ?>>Donation</option>     
                    </select>
                    <p>Select Service Payment if you want to accept payments for your services other wise select donation.</p>
                </td>
            </tr>
            <?php if(get_option('wp_sppd_type')=='donation') { $dstyle="display:block;";} else {$dstyle="display:none;";} ?>
            <tr valign="top">
            	<td colspan="2" style="padding: 0;">
                	<table cellpadding="0" cellspacing="0" border="0" style="<?php echo $dstyle?>" id="wp_sppd_type_opt_donation" >
                    	<tr>
                            <th scope="row"><label for="amount"><?php _e('Amount', 'wp_sppd'); ?></label></th>
                            <td>
                                <input class="regular-text" type="text" id="wp_sppd_amount" name="wp_sppd_amount" value="<?php echo get_option('wp_sppd_amount') ?>" />
                                <p class="description">The default amount for a donation (Optional).</p>
                            </td>                
                        </tr>
                	</table>
                 </td>   
            </tr>
             <?php if(get_option('wp_sppd_type')=='payments') { $pstyle="display:block;";} else {$pstyle="display:none;";} ?>            
            <tr valign="top">
            	<td colspan="2" style="padding: 0;">
                	<table cellpadding="0" cellspacing="0" border="0" style="<?php echo $pstyle?>" id="wp_sppd_type_opt_services">
                    	<?php for($i=1; $i<11; $i++) { ?>
                            <tr valign="top">
                                <th scope="row"><label for="payment_options"><?php _e("Payment Option#$i", 'wp_sppd'); ?></label></th>
                                <td>
                                    <input class="regular-text" type="text" id="wp_sppd_payment_option_<?php echo $i;?>" name="wp_sppd_payment_option_<?php echo $i;?>" value="<?php echo get_option("wp_sppd_payment_option_$i") ?>" />
                                    Price <input class="regular-text" style="width:100px;" type="text" id="wp_sppd_payment_option_price_<?php echo $i;?>" name="wp_sppd_payment_option_price_<?php echo $i;?>" value="<?php echo get_option("wp_sppd_payment_option_price_$i") ?>" />
                                </td>
                            </tr>
                            <?php } ?>
                    </table>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="title"><?php _e('Widget Title', 'wp_sppd'); ?></label></th>
                <td>
                <input name="wp_sppd_title" type="text" id="wp_sppd_title" value="<?php echo get_option('wp_sppd_title') ?>" class="regular-text">
                <p>It will display as payment heading.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="desc"><?php _e('Widget Description', 'wp_sppd'); ?></label></th>
                <td>
                	<textarea name="wp_sppd_desc" id="wp_sppd_desc" rows="5" cols="100"><?php echo get_option('wp_sppd_desc') ?></textarea>
                     <p>It will display description of the payment.</p>
                </td>
            </tr>            
            
            <tr valign="top">
                <th scope="row"><label for="button"><?php _e('Select Button Type', 'wp_sppd'); ?></label></th>
                <td>
                	<input name="wp_sppd_button" type="radio" id="paynowcc" value="btn_paynow_cc.gif" <?php if(get_option('wp_sppd_button')=='btn_paynow_cc.gif') { ?> checked="checked" <?php } ?>> 
                    <img src="<?php echo WP_SPPD_PLUGIN_URL; ?>/images/btn_paynow_cc.gif" style="margin:0 0 -20px 0;" />
                    <br /><br /><br />
                    <input name="wp_sppd_button" type="radio" id="donatecc" value="btn_donate_cc.gif" <?php if(get_option('wp_sppd_button')=='btn_donate_cc.gif') { ?> checked="checked" <?php } ?>>
                    <img src="<?php echo WP_SPPD_PLUGIN_URL; ?>/images/btn_donate_cc.gif" style="margin:0 0 -20px 0;" />
                    <br /><br /><br />
                    <input name="wp_sppd_button" type="radio" id="paynow" value="btn_paynow.gif" <?php if(get_option('wp_sppd_button')=='btn_paynow.gif') { ?> checked="checked" <?php } ?>>
                    <img src="<?php echo WP_SPPD_PLUGIN_URL; ?>/images/btn_paynow.gif" style="margin:0 0 -10px 0;" />                    
                    <br /><br /><br />
                    <input name="wp_sppd_button" type="radio" id="donate" value="btn_donate.gif" <?php if(get_option('wp_sppd_button')=='btn_donate.gif') { ?> checked="checked" <?php } ?>>
                    <img src="<?php echo WP_SPPD_PLUGIN_URL; ?>/images/btn_donate.gif" style="margin:0 0 -10px 0;" />                    
                    <br /><br /><br />
					<input name="wp_sppd_button" type="radio" id="customurl" value="customurl" <?php if(get_option('wp_sppd_button')=='customurl') { ?> checked="checked" <?php } ?>> Custom Url
                    <br />
                    <input name="wp_sppd_button_url" type="text" id="wp_sppd_button_url" value="<?php echo get_option('wp_sppd_button_url') ?>" class="regular-text">
                    <p>This is the button the visitors will click on to make Payments or Donations.</p>
                </td>
            </tr>   
            
            <tr valign="top">
                <th scope="row"><label for="returning-url"><?php _e('Return URL from PayPal', 'wp_sppd'); ?></label></th>
                <td>
                    <input name="wp_sppd_returning_url" type="text" id="wp_sppd_returning_url" value="<?php echo get_option('wp_sppd_returning_url') ?>" class="regular-text">
                    <p>Enter a return URL (could be a Thank You page). PayPal will redirect visitors to this page after Payment.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="returning-url"><?php _e('Return Cancel URL from PayPal', 'wp_sppd'); ?></label></th>
                <td>
                    <input name="wp_sppd_returning_url_cancel" type="text" id="wp_sppd_returning_url_cancel" value="<?php echo get_option('wp_sppd_returning_url_cancel') ?>" class="regular-text">
                    <p>Enter a return URL (could be a Why you Cancel Page page). PayPal will redirect visitors to this page after Cancel Payment.</p>
                </td>
            </tr>
        </tbody>
    </table>    
    <?php wp_nonce_field('wp_sppd_options'); ?>
    <?php submit_button(); ?>
    </form>
</div>