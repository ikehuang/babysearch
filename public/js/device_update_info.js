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
			$.blockUI({ message: '留言中...'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ message: '留言成功!'});

				setTimeout(function() {
					$.unblockUI();
					//alert(response.msg);
					if(response.status == 'success') {
						window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
					}
				}, 1000);
			}
			else {

				$.blockUI({ message: '留言失敗!'});
			}
		},
		error:function() {
			$.blockUI({ message: '留言失敗!'});
		}
	});
};