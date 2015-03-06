
$(document).ready(function(){
	var options = {
                  showUpload: false,
                  allowedFileTypes : ['image'],
                  allowedFileExtensions: ['jpeg', 'jpg', 'png'],
                  maxFileSize: 1024,
                  initialPreview: ['<img src="'+$('#current-user-avatar').attr('src')+'" class="file-preview-image">']
                }
	initializeFileInput($('#avatar'),options);

	var form = $('#edit-profile-form');

	form.find('.fileinput-remove').click(function(e){
	    form.find('#_delete').val(1);
	});

	form.find('#avatar').change(function(e){
	  form.find('#_delete').val('');
	});
});