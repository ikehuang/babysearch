$(document).ready(function(){
	$.init_form();
});

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ message: '留言中...'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ message: '留言成功!'});
			}
			else {
				$.blockUI({ message: '留言失敗!'});
			}
			
			setTimeout(function() {
				$.unblockUI();
				//alert(response.msg);
				if(response.status == 'success') {
					window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ message: '留言失敗!'});
		}
	});
};
