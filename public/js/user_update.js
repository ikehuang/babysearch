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
					window.location.href = '/user/';
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ message: '更新失敗!'});
		}
	});
};

$(document).ready(function() {
	$.init_user_event();
	$.init_form();
});