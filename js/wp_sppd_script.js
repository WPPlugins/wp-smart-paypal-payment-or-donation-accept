jQuery(document).ready(function($) {
	$("#wp_sppd_type").change(function() {		
		if($("#wp_sppd_type").val()=="payments")
		{
			$("#wp_sppd_type_opt_donation").hide();
			$("#wp_sppd_type_opt_services").show();
		}
		else
		{
			$("#wp_sppd_type_opt_services").hide();
			$("#wp_sppd_type_opt_donation").show();
			
		}
	});		
	$('#wp_sppd_options').on('submit', function() {
		var opt = "wp_sppd_payment_option_";
		var opt_price = "wp_sppd_payment_option_price_";
		if($("#wp_sppd_type").val()=="payments")
		{
			if($("#wp_sppd_payment_option_1").val()=="")
			{
				$("#wp_sppd_payment_option_1").addClass("wp_sppd_error");
				return false;
			}
			if($("#wp_sppd_payment_option_price_1").val()=="")
			{
				$("#wp_sppd_payment_option_price_1").addClass("wp_sppd_error");
				return false;
			}
			for(i=1; i<11; i++)
			{
				if(($("#wp_sppd_payment_option_"+i).val()!="" && $("#wp_sppd_payment_option_price_"+i).val()=="") || ($("#wp_sppd_payment_option_"+i).val()=="" && $("#wp_sppd_payment_option_price_"+i).val()!="") )
				{
					$("#wp_sppd_payment_option_"+i).addClass("wp_sppd_error");
					$("#wp_sppd_payment_option_price_"+i).addClass("wp_sppd_error");
					return false;
				}
			}
			
		}
		if($("#wp_sppd_type").val()=="donation")
		{
			if($("#wp_sppd_amount").val()=="")
			{
				$("#wp_sppd_amount").addClass("wp_sppd_error");
				return false;
			}			
		}
		if($('input[name=wp_sppd_button]:radio:checked').val()=="customurl")
		{			
			if($("#wp_sppd_button_url").val()=="")
			{
				$("#wp_sppd_button_url").addClass("wp_sppd_error");
				return false;
			}
		}
	});	
});