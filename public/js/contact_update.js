$(document).ready(function(){
	$.init_form();
});

$.init_form = function() {

	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新聯絡人資料中...</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新聯絡人資料成功!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});

				setTimeout(function() {
					$.unblockUI();
					//alert(response.msg);
					if(response.status == 'success') {
						history.go(-1);
					}
				}, 1000);
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>更新聯絡人資料失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
			}
		},
		error:function() {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>更新聯絡人資料失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		}
	});
};
