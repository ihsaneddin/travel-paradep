function appendCarousel(carouselPrototype,carousel)
{
	var inner = carouselPrototype.find('div.carousel-inner'),
		lastItem = inner.find('div.item:last'); 
	if (lastItem.find('div.row div.carousel-image-item').length == 4) inner.append('<div class="item"><div class="row"></div></div>'); 
	lastItem = inner.find('div.item:last');
	lastItem.find('div.row').append(carousel);

}
function appendCarouselIndicators(carouselPrototype)
{
	var ol = carouselPrototype.find("ol.carousel-indicators"),
		olPrototype = ol.clone(),
		indicatorPrototype = ol.find("li:last").clone(),
		slide = parseInt(indicatorPrototype.attr('data-slide-to')),
		items = carouselPrototype.find('div.carousel-inner div.item');
	ol.find('li').remove();
	items.each(function(){
		indicatorPrototype = olPrototype.find("li:last").clone();
		indicatorPrototype.attr('data-slide-to', slide++);
		if (indicatorPrototype.hasClass('active')) indicatorPrototype.removeClass('active') ;
		ol.append(indicatorPrototype);
	});
	ol.find('li:first').addClass('active');
}

$(document).ready(function(){
	var photosData = $('#car-photos-list').find('ul li'),
		actual = $('.car-photos-carousel-prototype'),
		carouselPrototype = actual.clone(),
		itemProtoType = carouselPrototype.find('div.item').clone(),
		apppendOn = $('.panel-default'),
		maxItem=4;

	carouselPrototype.find('div.item div.row div').remove();

	photosData.each(function(){
		var carousel = itemProtoType.find('.carousel-image-item').clone();
		carousel.find('a.thumbnail').attr('href', $(this).attr('data-target'));
		carousel.find('a.thumbnail').attr('title', $(this).attr('data-text'));
		carousel.find('a.thumbnail img').attr('src', $(this).attr('data-href'));
		carousel.attr('id', 'caraousel-'+$(this).attr('data-id'));
		appendCarousel(carouselPrototype,carousel);

	});
	carouselPrototype.find('div.item:first').addClass('active');
	carouselPrototype.removeClass('car-photos-carousel-prototype');
	carouselPrototype.addClass('car-photos-carousel');
	appendCarouselIndicators(carouselPrototype);
	if (carouselPrototype.find('div.item').length) carouselPrototype.find('div.remove-image-buttons').show();
	actual.remove();
	photosData.remove();

	$('.panel-default').append(carouselPrototype);
	$('.carousel-image-item').mouseover(function(){
		var container = $(this);
		container.find('.remove-photo').show();
		container.find('.select-remove-photo').show();
	}).mouseout(function(){
		var container = $(this);
		container.find('.remove-photo').hide();
		container.find('.select-remove-photo').each(function(){
			if ($(this).find('input[type=checkbox]:checked').length) $(this).show();
			else $(this).hide();
		})
	});

	$('.select-photo-to-remove').change(function(){
		var removeDiv = $('.remove-image-buttons'),
			removeSelected = removeDiv.find('.remove-selected-image-button').show();
		if ($(this).checked) removeSelected.show();
		else
		{
			if ($('input.select-photo-to-remove:checked').length) removeSelected.show();
			else removeSelected.hide();
		}
	});
});