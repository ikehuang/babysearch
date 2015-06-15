//for uploading picture thumbnail
$.readURL = function(input) {
	//console.log(input.files[0]);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic')
                .attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$.init_user_event = function() {
	$('input[name="photos"]').change(function(){
		$.readURL(this);
	});
	
	$('#upload_btn').click(function(){
		$('input[name="photos"]').trigger('click');
	});
};

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新中...</h1>'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新成功!</h1>'});
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新失敗!</h1>'});
			}
			
			setTimeout(function() {
				$.unblockUI();
				if(response.status == 'success') {
					//window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
					window.location.href = '/user/';
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新失敗!</h1>'});
		}
	});
};

$(document).ready(function() {
	$.init_user_event();
	$.init_form();
	
	$("#updateUser_btn" ).click(function() {
		// check input value
		if($('#update_user_form input[name="nickname"]').val().length == 0) {
			alert('請輸入您的暱稱!');
			return false;
		}
		if($('#update_user_form input[name="firstname"]').val().length == 0) {
			alert('請輸入您的名字!');
			return false;
		}
		if($('#update_user_form input[name="lastname"]').val().length == 0) {
			alert('請輸入您的姓氏!');
			return false;
		}
	});
});