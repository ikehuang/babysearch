$(document).ready(function() {
	
	$("#notice_container").hide();
	
	$(".tab" ).click(function() {
		if($(this).hasClass("notication_tab")) {
			$("#info_container").hide();
			$("#notice_container").show();
			
			//$('#tab_container .notication_tab').attr('style', 'background-image:url("/img/02/bu-01-01.png");background-repeat:no-repeat;');
			//$('#tab_container .info_tab').attr('style', 'background-image:url("/img/02/bu-02-01.png");background-repeat:no-repeat;');
			//$('#info_background').attr('src', '/img/02/bu-02-01.png');
		}
		else {
			$("#info_container").show();
			$("#notice_container").hide();
			
			//$('#tab_container .notication_tab').attr('style', 'background-image:url("/img/02/bu-01-02.png");background-repeat:no-repeat;');
			//$('#tab_container .info_tab').attr('style', 'background-image:url("/img/02/bu-02-02.png");background-repeat:no-repeat;');
			//$('#notice_background').attr('src', '/img/02/bu-01-02.png');
			//$('#info_background').attr('src', '/img/02/bu-02-02.png');
		}
		
	});
});