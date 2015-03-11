<div class="modal fade" id="car-photos-upload-modal" role="dialog" aria-labelledby="carModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">
					Upload Car Photos
				</h4>
			</div>
			<div class="modal-body">
				{{ Form::model($car, ['route' => Helpers::createOrUpdateRoute($car), 
				             'class' => 'form form-horizontal update-data-table form-car',
				              'id' => 'car-upload-photos-form', 'method' => Helpers::createOrUpdateMethod($car)]) }}

				    <div class="form-group">
				      <div class="col-md-12">
				        {{ Form::file('photos[][image]', array('class' => 'form-control file-loading', 'multiple' => true, 'id' => 'upload-car-photos')) }}
				      </div>
				    </div>

				{{Form::close()}}
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var uploadCarPhotosForm = $('#car-upload-photos-form');
    if (uploadCarPhotosForm.length)
    {
    	var form = uploadCarPhotosForm,
    		url = form.attr('action');
    	form.find('#upload-car-photos').fileinput(
    	{
		    uploadUrl: url,
		    uploadAsync: false,
		    maxFileCount: 10,
		    allowedFileTypes: ["image"],
		    allowedFileExtensions: ["jpeg", "jpg", "png"],
		    uploadExtraData: {
	        	_method: 'PUT'
	    	}
    	});
    }

    $('#upload-car-photos').on('fileuploaded', function(event, data, previewId, index) {
    	 var response = data.response;
    	 console.log(response.photos[response.photos.length - 1]);
	});
  });
</script>