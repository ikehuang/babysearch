$(document).ready(function(){
	$.init_event();
	$.init_form();
});

$.init_event = function() {
	//determine which forms to hide at first
	switch(device_type) {
		case 'Pets':
			$("#updatePet").show();
			$("#updateHuman").hide();
			$("#updateValuable").hide();
			break;
		case 'Human':
			$("#updatePet").hide();
			$("#updateHuman").show();
			$("#updateValuable").hide();
			break;
		case 'Valuables':
			$("#updatePet").hide();
			$("#updateHuman").hide();
			$("#updateValuable").show();
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
					window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ message: '更新失敗!'});
		}
	});
};
