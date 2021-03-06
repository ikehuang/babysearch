$(document).ready(function(){
	$.init_form();
});

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新遺失資料中...</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新遺失資料成功!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});

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
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新遺失資料失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
			}
		},
		error:function() {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新遺失資料失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		}
	});
};
