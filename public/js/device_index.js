$(document).ready(function() {
	
	$("#info_container").hide();
	
	$(".tab" ).click(function() {
		if($(this).hasClass("notication_tab")) {
			$("#info_container").hide();
			$("#notice_container").show();
		}
		else {
			$("#info_container").show();
			$("#notice_container").hide();
		}
		
	});
});