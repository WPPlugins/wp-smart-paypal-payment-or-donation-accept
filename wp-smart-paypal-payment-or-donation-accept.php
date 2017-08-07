<?php
/*
Plugin Name: WP Smart Paypal Payment or Donation Accept
Plugin URI: http://www.innovativeroots.com/
Version: 1.1
Description: WordPress Smart Paypal Payment or Donation Accept  is a plugin created for Freelancers, Charities and Nonprofit Organizations who want to accept payment of their services or wants to accept donation for their website.
Author: Muhammad Bilal
Author URI: http://www.innovativeroots.com/
Company: Innovative Roots
Company URI: http://www.innovativeroots.com/
* License: GPL2
*/

define( 'WP_PATH', dirname(__FILE__) . '/' );
	include_once(WP_PATH.'includes/options.php');
if ( ! defined( 'WP_SPPD_BASENAME' ) )
	define( 'WP_SPPD_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_SPPD_PLUGIN_NAME' ) )
	define( 'WP_SPPD_PLUGIN_NAME', trim( dirname( WP_SPPD_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_SPPD_PLUGIN_URL' ) )
	define( 'WP_SPPD_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_SPPD_PLUGIN_NAME );

if ( ! defined( 'currency' ) )
	define( 'currency', serialize($currency) );
if ( ! defined( 'options' ) )
	define( 'options', serialize($options) );	
add_action('init', 'wp_sppd_init_method');

function wp_sppd_init_method() {
    wp_enqueue_script('jquery');	
	if(is_admin())
	{		
		if(isset($_REQUEST['page']))
		{
			if($_REQUEST['page']=="wp_sppd_settings")
			{
				wp_register_script('wp-sppd-script',plugins_url('js/wp_sppd_script.js',__FILE__), array('jquery'));
				wp_enqueue_script('wp-sppd-script');
				
				wp_register_style('wp-sppd-css',plugins_url('css/wp_sppd_css.css', __FILE__));
				wp_enqueue_style( 'wp-sppd-css' );
			}
		}	
	}
	else
	{	
		wp_register_script('wp-sppd-main',plugins_url('js/wp_sppd_main.js',__FILE__), array('jquery'));
		wp_enqueue_script('wp-sppd-main');
		wp_register_style('wp-sppd-css',plugins_url('css/wp_sppd.css', __FILE__));
		wp_enqueue_style( 'wp-sppd-css' );
	}	
}
 
add_action( 'admin_menu', 'wp_sppd_menu');
function wp_sppd_menu() {
	add_options_page('WP Smart Payment', 'WP Smart Payment', 'manage_options', "wp_sppd_settings",'wp_sppd_settings');
}

function wp_sppd_settings(){
	
	include_once(WP_PATH.'includes/page-options.php');
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'wp_sppd_activation'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'wp_sppd_deactivation' );



function wp_sppd_activation() {	
	foreach(unserialize(options) as $key => $values) {
		add_option($key, $values);
	}	
}

function wp_sppd_deactivation() {
	foreach(unserialize(options) as $key => $values) {
		delete_option($key);
	}	
}


class wp_sppd_plugin extends WP_Widget {

	// constructor
	function wp_sppd_plugin() {
		parent::WP_Widget(false, $name = __('Smart Paypal Payment', 'wp_plugins') );
	}

	

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
      	$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] =  $new_instance['text'];   	
     	return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		echo $before_widget;
        if ( $title )
		echo $before_title . $title . $after_title; 
		if( $text ) {echo '<p>'.$text.'</p>';}
		if (function_exists('wp_sppd_payment')) echo wp_sppd_payment(); 
		echo $after_widget; 
	}
	// widget form creation
	function form($instance) {	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $text = esc_attr($instance['text']);		
		} else {
			 $title = 'Buy me a cup of coffee?';
			 $text = 'WordPress Smart Paypal Payment or Donation Accept Plugin is an easy to use WordPress plugin to Accept Paypal payment for a service or a product or Donation in one click. Can be used in the sidebar, posts and pages.';
		}
	?>	
	
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Desc:'); ?> <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10" cols="20"><?php echo $text; ?></textarea></label></p>	
	<?php 
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_sppd_plugin");'));
add_shortcode('wp_sppd_payment', 'wp_sppd_payment');
function wp_sppd_payment() {
	if(get_option('wp_sppd_button')=='customurl')
		$btn_img = get_option('wp_sppd_button_url');
	else
		$btn_img = WP_SPPD_PLUGIN_URL.'/images/'.get_option('wp_sppd_button');
		
		
	if(get_option('wp_sppd_type')=='donation')
	{
		$item_name = "Donation";
		$ammount = get_option('wp_sppd_amount');
		$btn_type = "_donations";
	} else {
		$item_name = "Service Payment";
		$ammount = get_option("wp_sppd_payment_option_price_1");
		$btn_type = "_xclick";
	}
	
	if(get_option('wp_sppd_type')=='donation'){
		?>
        <div class="wp_sppd_form">
        <p><label for="amount" class="wp_sppd_label"><?php _e('Amount', 'wp_sppd'); ?></label> <input type="text" name="wp_sppd_amount" id="wp_sppd_amount" class="wp_sppd_input" value="<?php echo get_option('wp_sppd_amount')?>" /></p>        
	<?php

	}
	else
	{
		?>
        <div class="wp_sppd_form">
		<p><label for="service-plan" class="wp_sppd_label"><?php _e('Service Plan', 'wp_sppd'); ?></label>
        	<select name="service_plan" id="service_plan">
            	<?php for($i=1;$i<11;$i++) { ?>
                <?php if(get_option("wp_sppd_payment_option_price_$i")!="" && get_option("wp_sppd_payment_option_$i")!="") { ?>
                <option value="<?php echo get_option("wp_sppd_payment_option_price_$i")?>"><?php echo get_option("wp_sppd_payment_option_$i") ?></option>
                <?php } ?>
                <?php } ?>
            </select>
            
        </p>
     <?php
	}
	?>
    <p><a href="javascript:document.wp_sppd_paypal_form.submit();"><img src="<?php echo $btn_img;?>" /></a></p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="wp_sppd_paypal_form">
        <input type="hidden" name="cmd" value="<?php echo $btn_type ?>">
        <input type="hidden" name="business" value="<?php echo get_option('wp_sppd_email')?>">
        <input type="hidden" name="item_name" value="<?php echo $item_name ?>">
        <input type="hidden" name="item_number" value="1">
        <input type="hidden" name="amount" id="ammount_plan" value="<?php echo $ammount ?>">
        <input type="hidden" name="no_shipping" value="0">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="currency_code" value="<?php echo get_option('wp_sppd_currency')?>">
        <input type="hidden" name="cancel_return" value="<?php echo get_option('wp_sppd_returning_url_cancel')?>">        
        <input type="hidden" name="return" value="<?php echo get_option('wp_sppd_returning_url')?>">        
    </form>
    </div>
    <?php
}
?>