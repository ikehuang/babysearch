$(document).ready(function(){
	$.init_form();
});

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>留言中...</h1>'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>留言成功!</h1>'});
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>留言失敗!</h1>'});
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
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>留言失敗!</h1>'});
		}
	});
};
