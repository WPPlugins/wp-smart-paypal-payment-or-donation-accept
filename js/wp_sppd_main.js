jQuery(document).ready(function($) {
	$("#service_plan").change(function() {
		$("#ammount_plan").val($("#service_plan").val());
	});	
});