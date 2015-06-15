$(document).ready(function() {
	$.init_event();
	$.init_form ();
	

	if($("input[name='photos']").length > 0)
		$('#pic').show();
});

$.init_event = function() {
	$('#upload_btn,#pic').click(function(){
		$("input[name='photos']").focus().trigger('click');
	});

	$("input[name='photos']").change(function(e){
		readURL(this);
	});
	
	$('input[name="open"]').change(function(){
		var self = $(this);
		$.ajax({
			url:"/device/updateOpenStatus?serial_number="+$("input[name='serial_number']").val()+"&status="+self.val(),
			beforeSubmit:function(e) {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新公開狀態中...</h1>'});
			},
			success:function(response) {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新公開狀態成功!</h1>'});

				setTimeout(function() {
					$.unblockUI();
					window.location.href = window.location.href;
				}, 1000);
			}
		});
	});
	
	$('input[name="status"]').change(function(){
		var self = $(this);
		$.ajax({
			url:"/device/updateStatus?serial_number="+$("input[name='serial_number']").val()+"&status="+self.val(),
			beforeSubmit:function(e) {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新遺失狀態中...</h1>'});
			},
			success:function(response) {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新遺失狀態成功!</h1>'});

				setTimeout(function() {
					$.unblockUI();
					window.location.href = window.location.href;
				}, 1000);
			}
		});
	});
};

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#pic')
                .attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
        
        $('form').trigger('submit');
    }
};


$.init_form = function() {
	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>照片更新中...</h1>'});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>照片更新成功!</h1>'});
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>新增失敗!</h1>'});
			}
			
			setTimeout(function() {
				$.unblockUI();
				if(response.status == 'success') {
					//window.location.href = '/guestbook/list?serial_number='+$("input[name='serial_number']").val();
				}
			}, 1000);
		},
		error:function() {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>照片更新失敗!</h1>'});
		}
	});
};
