$.fn.reload = function() {
    return $(this.selector);
};

function appendCarousel(carouselPrototype,carousel)
{
	var inner = carouselPrototype.find('div.carousel-inner'),
		lastItem = inner.find('div.item:last');
	lastItem.find('div.row div.carousel-image-item-prototype').remove();
	if (lastItem.find('div.row div.carousel-image-item').length == 4)
	{
		inner.append('<div class="item"><div class="row"></div></div>');
		appendCarouselIndicator(carouselPrototype);
		showCarouselControl(carouselPrototype);
	}
	lastItem = inner.find('div.item:last');
	appendDeletePhotoInput(carouselPrototype.find('form#delete-photos-form'), carousel.find('div.remove-photo a.remove-a-photo').attr('data-delete'));
	lastItem.find('div.row').append(carousel);
}

function showCarouselControl(carouselPrototype)
{
	var control = carouselPrototype.find('a.carousel-control');
	if (carouselPrototype.find('div.carousel-inner div.item').length > 1) control.removeClass('hidden');
	else control.addClass('hidden');
}

function appendCarouselIndicator(carouselPrototype)
{
	var ol = carouselPrototype.find("ol.carousel-indicators"),
		indicatorPrototype = ol.find("li:last").clone(),
		slide = parseInt(indicatorPrototype.attr('data-slide-to')),
		indicatorPrototype = ol.find("li:last").clone();
	indicatorPrototype.attr('data-slide-to', slide+1);
	if (indicatorPrototype.hasClass('active')) indicatorPrototype.removeClass('active') ;
	ol.append(indicatorPrototype);
}
function carouselUp(carouselPrototype, to, proto, photosData)
{
	carouselPrototype.find('div.item:first').addClass('active');
	carouselPrototype.removeClass('photos-carousel-prototype');
	carouselPrototype.addClass('photos-carousel');
	if (carouselPrototype.find('div.item').length) carouselPrototype.find('div.remove-image-buttons').show();
	carouselPrototype.find('ol.carousel-indicators li:first').addClass('active');
	proto.remove();
	to.append(carouselPrototype);
}

function carouselDown(carouselContainer){
	carouselContainer.hide();
}

function carouselItem(carouselPrototype, itemProtoType, data )
{
	carousel = itemProtoType.find('.carousel-image-item:last').clone();
	carousel.find('a.thumbnail').attr('href', data.original_url);
	carousel.find('a.thumbnail').attr('title', data.image_file_name);
	carousel.find('a.thumbnail img').attr('src', data.carousel_url);
	carousel.attr('id', 'carousel-'+data.id);
	carousel.find('div.remove-photo a').attr('data-delete', 'remove-photo-'+data.id)
	carousel.find('div.select-remove-photo input[type=checkbox]').attr('data-delete', 'remove-photo-'+data.id);
	carousel.removeClass('carousel-image-item-prototype');
	return carousel;
}

function appendCarouselUpload(photoData)
{
	var actual = $('.photos-carousel'),
		proto = $('.photos-carousel-prototype'),
		apppendOn = $('.panel-default');
	if (proto.length)
	 {
	 	var carouselPrototype = proto.clone(),
			itemProtoType = carouselPrototype.find('div.item').clone();
	 	appendCarousel(carouselPrototype, carouselItem(carouselPrototype, itemProtoType, photoData ));
	 	carouselUp(carouselPrototype, apppendOn, proto);
	 }
	 else
	 {
		var itemProtoType = actual.find('div.item:last').clone();
		appendCarousel(actual, carouselItem(actual, itemProtoType, photoData ));
		actual.show();
	 }
}

function getDeletePhotoInput(form,inputDelete)
{
	var inputs = form.find('input[type=hidden].'+inputDelete);
	if (!inputs.length)
	{
		appendDeletePhotoInput(form,inputDelete);
	}
	inputs = inputs.reload();
	var method = form.find('input[name=_method]');
	var token = form.find('input[name=_token]');
	inputs =  $.merge($.merge(method,token),inputs);
	return inputs;
}

function appendDeletePhotoInput(form,inputDelete)
{
	var inputProto = form.find('input[type=hidden].prototype-input').clone(),
		id = inputDelete.split('-')[inputDelete.split('-').length-1],
		index = parseInt(form.find('input[type=hidden].photo:last').attr('data-index'));
		index = isNaN(index) ? 0 : index+1;
	inputProto.each(function(){
		$(this).val( $(this).hasClass('prototype-input-id') ? id : $(this).val() );
		$(this).val( $(this).hasClass('prototype-input-delete') ? 1 : $(this).val() );
		$(this).addClass(inputDelete+' photo');
		$(this).attr('data-index', index);
		setInputName($(this));
	});
	inputProto.removeClass('prototype-input prototype-input-id prototype-input-delete');
	form.append(inputProto);
}



function setInputName(input)
{
	if (input.attr('data-index') != '' && input.attr('data-relation') != '' && input.attr('data-name') != '')
	{
		var name = input.attr('data-relation')+'['+input.attr('data-index')+']['+input.attr('data-name')+']';
		input.attr('name', name);
	}
}

function removeLastCarouselIndicator(item)
{
	$(item).parents('div.carousel').find('ol.carousel-indicators li:last').remove();
}


$(document).ready(function(){
	var photosData = $('#photos-list').find('ul li'),
		actual = $('.photos-carousel'),
		proto = $('.photos-carousel-prototype'),
		carouselPrototype = proto.clone(),
		itemProtoType = carouselPrototype.find('div.item').clone(),
		carouselItemPrototype = itemProtoType.find('.carousel-image-item-prototype').clone(),
		apppendOn = $('.panel-default'),
		maxItem=4;

	carouselPrototype.find('div.item div.row div').remove();

	if (photosData.length)
	{
		photosData.each(function(){
			data = {id: $(this).attr('data-id'), original_url: $(this).attr('data-target'),
					carousel_url: $(this).attr('data-href'), image_file_name: $(this).attr('data-text')}
			appendCarousel(carouselPrototype, carouselItem(carouselPrototype, itemProtoType, data ));
		});
		carouselUp(carouselPrototype, apppendOn, proto);
		photosData.remove();
	}

	$('div').on('mouseover', '.carousel-image-item', function(){
		var container = $(this);
		container.find('.remove-photo').show();
		container.find('.select-remove-photo').show();
	}).on('mouseout', '.carousel-image-item', function(){
		var container = $(this);
		container.find('.remove-photo').hide();
		container.find('.select-remove-photo').each(function(){
			if ($(this).find('input[type=checkbox]:checked').length) $(this).show();
			else $(this).hide();
		});
	});

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
    	var response = data.response,
    	 	photoData = response.photos[response.photos.length - 1];

    	 appendCarouselUpload(photoData);
    	 $(this).parents('div#car-photos-upload-modal').modal('hide');
    	 notify({ 'type' : 'success', 'title' : 'Success', 'message' : 'Files are uploaded', 'timeout' : 5 });
    	 $(this).fileinput('clear');

	}).on('filebatchuploadsuccess', function(event, data){
		var photos = data.response.photos,
			dataPhotos = photos.length == data.files.length ? photos : photos.slice(Math.max(photos.length - data.files.length, 1));

		$.each(dataPhotos, function(){
			appendCarouselUpload(this);
		});
		notify({ 'type' : 'success', 'title' : 'Success', 'message' : 'Files are uploaded', 'timeout' : 5 });
		$(this).parents('div#car-photos-upload-modal').modal('hide');
	});


	$(document).on('change', 'input[type=checkbox].select-photo-to-remove', function(){
		var removeDiv = $('.remove-image-buttons'),
			removeSelected = removeDiv.find('.remove-selected-image-button').show();
		if ($(this).checked) {

			removeSelected.show();
		}
		else
		{
			if ($('input.select-photo-to-remove:checked').length) removeSelected.show();
			else removeSelected.hide();
		}
	});

	var	formDeletePhoto = $('form#delete-photos-form'),
		deletePhotoUrl = form.attr('action');

	$(document).on('click','a.remove-a-photo', function(e){
		var carousel = $(this).parents('div.carousel-image-item'),
			inputDelete = $(this).attr('data-delete'),
			photoId = inputDelete.split('-'),
			id = photoId[photoId.length-1],
			form = formDeletePhoto;
		data = getDeletePhotoInput(form,inputDelete).serialize();
		deletePhotos(form,data,carousel,carouselItemPrototype);
		e.preventDefault();
		return false;

	});

	$(document).on('click', 'button.remove-selected-image-button', function(e){
		var form = $('form'+$(this).attr('data-form')),
			carouselContainer = form.parents('div.photos-carousel');
		deleteSelectedPhotos(form, carouselContainer,carouselItemPrototype,true);
		$(this).hide();
		e.preventDefault();
		return false;

	});

	$(document).on('click', 'button.remove-all-image-button', function(e){
		var form = $('form'+$(this).attr('data-form')),
			carouselContainer = form.parents('div.photos-carousel');
		deleteSelectedPhotos(form, carouselContainer,carouselItemPrototype,false);
		$(this).hide();
		e.preventDefault();
		return false;
	});
});

function deleteSelectedPhotos(form, carouselContainer,carouselItemPrototype,checked)
{
	var carousels;
	checked = checked ? ':checked' : '';
	carouselContainer.find('div.carousel-image-item input[type=checkbox].select-photo-to-remove'+checked).each(function(){
		var deleteClass = $(this).attr('data-delete'),
			inputs = form.find('.'+deleteClass),
			carousel = $(this).parents('div.carousel-image-item');
		carousels =  typeof carousels !== 'undefined' ? $.merge(carousels, carousel) : carousel;
		data = typeof data !== 'undefined' ? $.merge(data, inputs) : inputs;
	});
	data = appendToken(form,data).serialize();
	deletePhotos(form,data,carousels,carouselItemPrototype);
}

function deletePhotos(form,data,carousels,carouselItemPrototype)
{
	$.ajax({
		url: form.attr('action'),
		method : form.attr('method'),
		dataType: 'json',
		data: data,
		success:function(request){

			carousels.each(function(){
				var carousel = $(this),
					carouselContainer = carousel.parents('div.photos-carousel'),
					item = carousel.parents('div.item'),
					index = item.index();
				if (carouselContainer.find('.carousel-image-item').length == 1)
				{
					carousel.addClass('carousel-image-item-prototype');
					carouselDown(carouselContainer);
				}
				else carousel.remove();

				tidyupCarousel(carouselContainer,item,index);
				showCarouselControl(carouselContainer);
			});

		}

	});
}

function appendToken(form,data)
{
	var method = form.find('input[name=_method]');
	var token = form.find('input[name=_token]');
	data =  $.merge($.merge(method,token),data);
	return data;
}

function tidyupCarousel(container,item,index)
{
	container = typeof container !== 'undefined' ? container : $('.photos-carousel')[0];
	index = typeof index !== 'undefined' ? index : 0;
	items = typeof items !== 'undefined' ? items : items = $(container).find('div.item');
	item = typeof item !== 'undefined' ? item : item = items[index];

	var carousels = $(item).find('div.carousel-image-item'),
		next = index+1;
	if (carousels.length != 4 && $(items[next]).length)
	{
		if (tidy(item, items[next], 4 - carousels.length))
		{
			tidyupCarousel(container,items[next],next);
		}
	}
	else{
		if (!carousels.length)
		{
			removeLastCarouselIndicator($(item));
			$(items[$(item).index()-1]).addClass('active');
			$(item).remove();
		}
	}
}

function tidy(item, nextItem, i)
{
	var carousels = $(nextItem).find(".carousel-image-item");
	if (carousels.length)
	{
		var need = carousels.slice(0,i).detach();
		$(item).find('div.row').append(need);
		if ($(item).find(".carousel-image-item").length) return false;
		if ($(nextItem).find(".carousel-image-item").length) return true;
	}
	removeLastCarouselIndicator($(nextItem));
	$(nextItem).remove();
	return false;
}

function removeLastCarouselIndicator(item)
{
	$(item).parents('div.carousel').find('ol.carousel-indicators li[data-slide-to='+item.index()+']').remove();
}