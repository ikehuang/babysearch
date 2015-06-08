$(document).ready(function() {
	$.init_event();
	$.init_form();$('input[type=file]').click();
    return false;
});

$.init_event = function() {
	$('#add_photo_btn').click(function(){
		$("#photo_input").focus().trigger('click');
	});
	
	$("#photo_input").change(function(e){
		$('form').trigger('submit');
	});
	
	$('.delete_btn').click(function(){
		var photo_id = $(this).attr('photo_id');
		var self = $(this).parent();
		$.ajax({
			url:"/photo/delete?id="+photo_id,
			beforeSubmit:function(e) {
				$.blockUI({ message: '照片刪除中...'});
			},
			success:function(response) {
				if(response.status == 'success') {
					$.blockUI({ message: '照片刪除成功!'});

					setTimeout(function() {
						$.unblockUI();
						//alert(response.msg);
						if(response.status == 'success') {
							self.remove();
						}
					}, 1000);
				}
				else {

					$.blockUI({ message: '照片刪除失敗!'});
				}
			}
		});
	});
};

$.init_form = function() {
	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ message: '照片上傳中...'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ message: '照片上傳成功!'});

				setTimeout(function() {
					$.unblockUI();
					//alert(response.msg);
					if(response.status == 'success') {
						window.location.href = '/photo/list?serial_number='+$("input[name='serial_number']").val();
					}
				}, 1000);
			}
			else {

				$.blockUI({ message: '照片上傳失敗!'});
			}
		},
		error:function() {
			$.blockUI({ message: '照片上傳失敗!'});
		}
	});
};