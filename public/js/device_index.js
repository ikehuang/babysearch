$(document).ready(function() {
		
	if($(status == 'lost')) {
		$("#info_container").hide();
		$("#notice_container").show();
	
		$('#petInfo_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-left-radius", "0em");
		$('#petHealth_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-right-radius", "0em");
	}
	else {
		$("#info_container").show();
		$("#notice_container").hide();
		
		$('#petHealth_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-right-radius", "0em");
		$('#petInfo_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-left-radius", "0em");
	}
		
	$(".pet_tab" ).click(function() {
		if($(this).hasClass("pet_notication_tab")) {
			$("#info_container").hide();
			$("#notice_container").show();
			
			$('#petInfo_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-left-radius", "0em");
			$('#petHealth_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-right-radius", "0em");
			//$('.tab info_tab').css("background-image", "url('/img/02/bu-01-01.png') no-repeat").css("border-bottom-right-radius", "1em").css("border-bottom-left-radius", "0em");
			//$('.tab notication_tab').css("background-image", "url('/img/02/bu-02-01.png') no-repeat").css("border-bottom-left-radius", "1em").css("border-bottom-right-radius", "0em");
		}
		else {
			$("#info_container").show();
			$("#notice_container").hide();
			
			$('#petHealth_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-right-radius", "0em");
			$('#petInfo_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-left-radius", "0em");
			//$('.tab info_tab').css("background-image", "url('/img/02/bu-02-02.png') no-repeat").css("border-bottom-right-radius", "1em").css("border-bottom-right-radius", "0em");
			//$('.tab notication_tab').css("background-image", "url('/img/02/bu-01-02.png') no-repeat").css("border-bottom-left-radius", "1em").css("border-bottom-left-radius", "0em");
		}
		
	});
});