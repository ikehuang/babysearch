$(document).ready(function(){
	$.init_event();
	$.init_form();
	
	$("#updatePet_btn" ).click(function() {
		// check input value
		if($('#update_pet_form input[name="pet_name"]').val().length == 0) {
			alert('請輸入寵物名字!');
			return false;
		}
		if($('#update_pet_form input[name="pet_chip_number"]').val().length == 0) {
			alert('請輸入晶片號碼!');
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
});

$.init_event = function() {
	//determine which forms to hide at first
	switch(device_type) {
		case 'Pets':
			$("#updatePet").show();
			$("#updateHuman").hide();
			$("#update_valuable_form").hide();
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
	});
	
	$('#petHealth_tab').click(function(){
		$('#petInfo_container').hide();
		$('#healthStatus_container').show();
	});
};

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ message: '更新中...'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ message: '更新成功!'});
			}
			else {

				$.blockUI({ message: '更新失敗!'});
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
			$.blockUI({ message: '更新失敗!'});
		}
	});
};
