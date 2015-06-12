$(document).ready(function(){
	$.init_form();
});

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ message: '更新遺失資料中...'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ message: '更新遺失資料成功!'});

				setTimeout(function() {
					$.unblockUI();
					//alert(response.msg);
					if(response.status == 'success') {
						//window.location.href = '/device/update?serial_number='+$("input[name='serial_number']").val();
						history.go(-1);
					}
				}, 1000);
			}
			else {

				$.blockUI({ message: '更新遺失資料失敗!'});
			}
		},
		error:function() {
			$.blockUI({ message: '更新遺失資料失敗!'});
		}
	});
};
