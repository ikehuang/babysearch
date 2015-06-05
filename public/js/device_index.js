$(document).ready(function() {
	
	$("#info_container").hide();
	
	$("#notice_tab" ).click(function() {
		$("#notice_container").show();
		$("#info_container").hide();
		
		$("#notice_background").attr('src', '/img/02/bu-01-01.png');
		$("#info_background").attr('src', '/img/02/bu-02-01.png');
	});

	$("#info_tab" ).click(function() {
		$("#notice_container").hide();
		$("#info_container").show();
		
		$("#notice_background").attr('src', '/img/02/bu-01-02.png');
		$("#info_background").attr('src', '/img/02/bu-02-02.png');
	});
});