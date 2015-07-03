$(document).ready(function(){
	$.init_form();
	getLocation();
	
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
    	alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
	$('input[name="latitude"]').val(position.coords.latitude);
	$('input[name="longitude"]').val(position.coords.longitude);
}

$.init_form = function() {
	
	$('form').ajaxForm({
		beforeSubmit:function(e) {
			$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
			$.blockUI({ message: '<h1>留言中...</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		},
		success:function(response) {
			
			if(response.status == 'success') {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>留言成功!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
			}
			else {
				$.blockUI({ css: { backgroundColor:'transparent', color:'black'} });
				$.blockUI({ message: '<h1>留言失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
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
			$.blockUI({ message: '<h1>留言失敗!</h1>', css: { 'margin-left':'-25%', 'width':'80%', 'font-size':'2em' }});
		}
	});
};
