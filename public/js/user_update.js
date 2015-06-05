//for uploading picture thumbnail
$.readURL = function(input) {
	//console.log(input.files[0]);
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.blah')
                .attr('src', e.target.result)
                .width(250)
                .height(250);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$.init_user_event = function() {
	$('#update_user_form input[name="photos"]').change(function(){
		$.readURL(this);
	});
	
	$('#update_user_form  .upload_btn').click(function(){
		$('#update_user_form input[name="photos"]').trigger('click');
	});
};

$(document).ready(function() {
	$.init_user_event();
	$('.datepicker').datepicker({dateFormat: "yy-mm-dd"});

});