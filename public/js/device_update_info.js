$(document).ready(function(){
	$.init_event();
	$.init_form();

	switch(device_category) {
		case 'dogs':
			$("#dogs_subcategory").show();
			$("#cats_subcategory").hide();
			$("#dogs_vaccine").show();
			$("#cats_vaccine").hide();
			$("#dogs_bloodtype").show();
			$("#cats_bloodtype").hide();
			break;
		case 'cats':
			$("#dogs_subcategory").hide();
			$("#cats_subcategory").show();
			$("#dogs_vaccine").hide();
			$("#cats_vaccine").show();
			$("#dogs_bloodtype").hide();
			$("#cats_bloodtype").show();
			break;
		default:
			$("#cats_subcategory").hide();
			$("#dogs_subcategory").hide();
			$("#dogs_vaccine").hide();
			$("#cats_vaccine").hide();
			$("#dogs_bloodtype").hide();
			$("#cats_bloodtype").hide();
			break;
	}		
	
	$('select[name="pet_category"]').change(function(){

		if($(this).val() == 'dogs') {
			$("#dogs_subcategory").show();
			$("#cats_subcategory").hide();
			$("#dogs_vaccine").show();
			$("#cats_vaccine").hide();
			$("#dogs_bloodtype").show();
			$("#cats_bloodtype").hide();
		}
		else if($(this).val() == 'cats') {
			$("#dogs_subcategory").hide();
			$("#cats_subcategory").show();
			$("#dogs_vaccine").hide();
			$("#cats_vaccine").show();
			$("#dogs_bloodtype").hide();
			$("#cats_bloodtype").show();
		}
		else {
			$("#dogs_subcategory").hide();
			$("#cats_subcategory").hide();
			$("#dogs_vaccine").hide();
			$("#cats_vaccine").hide();
			$("#dogs_bloodtype").hide();
			$("#cats_bloodtype").hide();
			
		}
	});

	
	/*
	$("#updatePet_btn" ).click(function() {
		// check input value
		if($('#update_pet_form input[name="pet_name"]').val().length == 0) {
			alert('請輸入寵物名字!');
			return false;
		}
	});

	$("#addHuman_next" ).click(function() {
		// check input value
		if($('#update_human_form input[name="human_firstname"]').val().length == 0) {
			alert('請輸入人的名字!');
			return false;
		}
		if($('#update_human_form input[name="human_lastname"]').val().length == 0) {
			alert('請輸入人的姓氏!');
			return false;
		}
		if($('#update_human_form input[name="human_nickname"]').val().length == 0) {
			alert('請輸入人的暱稱!');
			return false;
		}
	});

	$("#addValuable_next" ).click(function() {
		if($('#update_valuable_form input[name="valuable_name"]').val().length == 0) {
			alert('請輸入物品名稱!');
			return false;
		}
	});
	*/
});

$.init_event = function() {
	//determine which forms to hide at first
	switch(device_type) {
		case 'Pets':
			$("#updatePet").show();
			$("#updateHuman").hide();
			$("#update_valuable_form").hide();
			$('#petHealth_tab').css("border-bottom-left-radius", "1em").css("border-bottom-right-radius", "0em");
			break;
		case 'Human':
			$("#updatePet").hide();
			$("#updateHuman").show();
			$("#update_valuable_form").hide();
			break;
		case 'Valuables':
			$("#updatePet").hide();
			$("#updateHuman").hide();
			$("#update_valuable_form").show();
			break;
		default:
			break;
	}
	
	$('#petInfo_tab').click(function(){
		$('#healthStatus_container').hide();
		$('#petInfo_container').show();
		
		$('#petInfo_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-left-radius", "0em");
		$('#petHealth_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-right-radius", "0em");
		//$('#petInfo_tab').css("background-size", "contain");
	});
	
	$('#petHealth_tab').click(function(){
		$('#petInfo_container').hide();
		$('#healthStatus_container').show();
		
		$('#petHealth_tab').css("background", "#4e88ff").css("border-bottom-right-radius", "1em").css("border-bottom-right-radius", "0em");
		$('#petInfo_tab').css("background", "#4e65c5").css("border-bottom-left-radius", "1em").css("border-bottom-left-radius", "0em");
		//$('#petHealth_tab').css("background-size", "contain");
	});
};

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新中...</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新成功!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
			}
			
			setTimeout(function() {
				$.unblockUI();
				if(response.status == 'success') {
					//window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
					history.go(-1);
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		}
	});
};
