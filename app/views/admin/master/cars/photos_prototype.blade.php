<div id='photos-list'>
	<ul data-id="{{ $car->id }}">
		@foreach($car->photos as $photo)
			<li data-href="{{ asset($photo->image->url('medium')) }}" data-target="{{ asset($photo->image->url('original')) }}" data-text="{{ $photo->image_file_name }}" data-id="{{$photo->id}}"></li>	
		@endforeach
	</ul>
</div>

<div class='photos-carousel-prototype'>
	<div class="container">
	    <div class="row">
			<div class="col-md-12">	        	
	            <div id="car-photos-carousel" class="carousel slide">	                 
	                <ol class="carousel-indicators">
	                    <li data-target="#car-photos-carousel" data-slide-to="0"></li>
	                </ol>	                 
	                <!-- Carousel items -->
	                <div class="carousel-inner">
		                <div class="item">
		                	<div class="row">
		                	  <div class="col-md-3 carousel-image-item carousel-image-item-prototype">
		                	  	<a href="#" class="thumbnail" title='prototype' data-gallery>
		                	  		<img src="" alt="prototype" style="height:200px;">
		                	  	</a>
		                	  	<div class="remove-photo">
									<a href="#" class='remove-a-photo'><i class='icon icon-remove-circle icon-remove-photo'></i></a>
								</div>
								<div class="select-remove-photo">
									<input type="checkbox" name="checkboxes" id="" value="id" class="inline select-photo-to-remove">
								</div>
		                	  </div>
		                	</div><!--.row-->
		                </div><!--.item-->
	                </div><!--.carousel-inner-->
	                  <a data-slide="prev" href="#car-photos-carousel" class="left carousel-control hidden">‹</a>
	                  <a data-slide="next" href="#car-photos-carousel" class="right carousel-control hidden">›</a>
	            </div><!--.Carousel-->
	                 
			</div>
		</div>
	</div>
	<div class="row remove-image-buttons">
		<center>
			<button class="btn btn-default remove-selected-image-button"><i class='icon icon-check'></i> Remove Selected</button>
			<button class="btn btn-default"><i class='icon icon-trash'></i> Remove All</button>
		</center>
	</div>
	{{ Form::model($car, ['route' => Helpers::createOrUpdateRoute($car), 
             'class' => 'form-car hidden',
              'id' => 'delete-photos-form', 'method' => Helpers::createOrUpdateMethod($car)]) }}

              {{ Form::hidden('photos[][id]', null, array('class' => 'hidden prototype-input prototype-input-id')) }}
              {{ Form::hidden('photos[][_delete]', 0, array( 'class' => 'hidden prototype-input prototype-input-delete' )) }}

    {{ Form::close() }}
</div>
