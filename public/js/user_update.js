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

$(document).ready(function() {
	$.init_user_event();

});