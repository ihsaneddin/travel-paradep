$(document).ready(function(){

	$('form.form-car').each(function(){
		var form =$(this);
		form.find('select').each(function(){
			if ( !$(this).hasClass('selectized') )
			{
				initSelectize($(this), {create:true});
				if ($(this).hasClass('need-manufacture'))
				{
					provideManufacture(form, $(this));
				}
			}
		});		
	}); 
});