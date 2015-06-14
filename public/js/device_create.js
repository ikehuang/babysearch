//for uploading picture thumbnail
$.readURL = function(input) {
	//console.log(input.files[0]);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.blah')
                .attr('src', e.target.result)
                .width(250)
                .height(250);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$.init_pet_event = function() {
	$('#create_pet_form input[name="photos"]').change(function(){
		$.readURL(this);
	});
	
	$('#create_pet_form  .upload_btn').click(function(){
		$('#create_pet_form input[name="photos"]').trigger('click');
	});
};

$.init_human_event = function() {
	$('#create_human_form input[name="photos"]').change(function(){
		$.readURL(this);
	});

	$('#create_human_form  .upload_btn').click(function(){
		$('#create_human_form input[name="photos"]').trigger('click');
	});
};

$.init_valuable_event = function() {
	$('#create_valuable_form input[name="photos"]').change(function(){
		$.readURL(this);
	});

	$('#create_valuable_form  .upload_btn').click(function(){
		$('#create_valuable_form input[name="photos"]').trigger('click');
	});
};

$(document).ready(function() {
	$.init_pet_event();
	$.init_human_event();
	$.init_valuable_event();

	//determine which tag label to switch on
	if(get_sn.length > 0) {
		switch(get_sn[2]){
			case 'Q':
				$("#qrcode").attr('src','/img/13/icon-01-01.png');
				break;
			case 'N':
				$("#nfc").attr('src','/img/13/icon-02-01.png');
				break;
			case 'B':
				$("#ble").attr('src','/img/13/icon-03-01.png');
				break;
			default:
				alert('序號格式不正確!');
				return false;
				break;
		}
	}
	
	$('.tagKind_container  img').click(function(){
		$("#qrcode").attr('src','/img/13/icon-01-02.png');
		$("#nfc").attr('src','/img/13/icon-02-02.png');
		$("#ble").attr('src','/img/13/icon-03-02.png');
		
		switch($(this).attr('id')){
			case 'qrcode':
				$("#qrcode").attr('src','/img/13/icon-01-01.png');
				break;
			case 'nfc':
				$("#nfc").attr('src','/img/13/icon-02-01.png');
				break;
			case 'ble':
				$("#ble").attr('src','/img/13/icon-03-01.png');
				break;
			default:
				return false;
				break;
		}
	});
	
	//hide these containers at first
	$("#addPet").hide();
	$("#addContacts1").hide();
	$("#addHuman").hide();
	$("#addContacts2").hide();
	$("#addValuable").hide();
	$("#addContacts3").hide();

	//after first step completed...
	$("#addSerial_next" ).click(function() {

		switch($("#sn").val()[0]){
			case 'P':
				$("#addSerial").hide();
				$("#addPet").show();
				$("#healthStatus_container").hide();					
				$("#addContacts1").hide();

				switch($("#sn").val()[2]){
					case 'Q':
						$('#type1').attr('src', '/img/14/ICON+TITLE-01.png');
						break;
					case 'N':
						$('#type1').attr('src', '/img/14/ICON+TITLE-02.png');
						break;
					case 'B':
						$('#type1').attr('src', '/img/14/ICON+TITLE-03.png');
						break;
					default:
						break;
				}
				break;
			case 'M':
				$("#addSerial").hide();
				$("#addHuman").show();
				$("#addContacts2").hide();

				switch($("#sn").val()[2]){
					case 'Q':
						$('#type2').attr('src', '/img/14/ICON+TITLE-01.png');
						break;
					case 'N':
						$('#type2').attr('src', '/img/14/ICON+TITLE-02.png');
						break;
					case 'B':
						$('#type2').attr('src', '/img/14/ICON+TITLE-03.png');
						break;
					default:
						break;
				}
				break;
			case 'T':
				$("#addSerial").hide();
				$("#addValuable").show();
				$("#addContacts3").hide();

				switch($("#sn").val()[2]){
					case 'Q':
						$('#type3').attr('src', '/img/14/ICON+TITLE-01.png');
						break;
					case 'N':
						$('#type3').attr('src', '/img/14/ICON+TITLE-02.png');
						break;
					case 'B':
						$('#type3').attr('src', '/img/14/ICON+TITLE-03.png');
						break;
					default:
						break;
				}
				break;
			default:
				alert('序號格式不正確!');
				return false;
			break;
		}

		$("#sn1").val( $("#sn").val());
		$("#sn2").val( $("#sn").val());
		$("#sn3").val( $("#sn").val());
	});
	
	//for tab hiding...
	$("#petInfo_tab" ).click(function() {
		$("#petInfo_container").show();
		$("#healthStatus_container").hide();
	});

	$("#petHealth_tab" ).click(function() {
		$("#petInfo_container").hide();
		$("#healthStatus_container").show();
	});

	//from step2 back to step1
	$("#addPet_back" ).click(function() {
		$("#addSerial").show();
		$("#addPet").hide();
		$("#addHuman").hide();
		$("#addValuable").hide();
	});

	$("#addHuman_back" ).click(function() {
		$("#addSerial").show();
		$("#addPet").hide();
		$("#addHuman").hide();
		$("#addValuable").hide();
	});

	$("#addValuable_back" ).click(function() {
		$("#addSerial").show();
		$("#addPet").hide();
		$("#addHuman").hide();
		$("#addValuable").hide();
	});

	//from step2 to step3
	$("#addPet_next" ).click(function() {
		// check input value
		if($('#create_pet_form input[name="pet_name"]').val().length == 0) {
			alert('請輸入竉物名字!');
			return false;
		}
		
		$("#addPet").hide();
		$("#addContacts1").show();
	});
	
	$("#addHuman_next" ).click(function() {
		$("#addHuman").hide();
		$("#addContacts2").show();
	});
	
	$("#addValuable_next" ).click(function() {
		$("#addValuable").hide();
		$("#addContacts3").show();
	});

	//from step3 back to step2
	$("#addContact1_back" ).click(function() {
		$("#addPet").show();
		$("#addContacts1").hide();
	});

	$("#addContact2_back" ).click(function() {
		$("#addHuman").show();
		$("#addContacts2").hide();
	});

	$("#addContact3_back" ).click(function() {
		$("#addValuable").show();
		$("#addContacts3").hide();
	});
});