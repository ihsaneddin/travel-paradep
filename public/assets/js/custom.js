//this file contains javascript custom for the app

//csrf token append to request head when ajax fired
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

//display loading when ajax fired
jQuery(document).ajaxStart(function (request) 
	{
		loading({'show' : true, 'message' : 'Please wait..'})
	}).ajaxStop(function () {
		//hide any modal-confirmation
		$('body #modal-confirmation').modal('hide');
		loading({'show' : false});
	}).ajaxError(function(){
		notify({ 'type' : 'error', 'title' : 'Error', 'message' : 'Your request can not be processed right now.', 'timeout' : 5 });
	});

function deleteRowRecord(event,element)
{
	var data = { 'href' : $(element).attr('href'), 'target' : $(element).attr('id'), 'method' : 'delete'};
	confirmationModal(confirmationModalType('delete'),data);
	event.preventDefault();
	return false;
}

//function to set confirmation modal
function confirmationModal(text,data)
{
	if ($('#modal-confirmation').length > 0) 
	{ 
		//set modal type
		$('#modal-confirmation #confirmation-type').removeClass().addClass('alert alert-'+text['alert']);
		$('#modal-confirmation .modal-body h4').text(text['confirm']);
		$('#modal-confirmation .modal-content modal-footer .confirmation-button').text(text['button']);
		
		//add data-href and data target to button confirm
		var confirm = $('#modal-confirmation .modal-content .modal-footer .confirmation-button');
		confirm.attr('data-href', data['href']);
		confirm.attr('data-target', data['target']);
		confirm.attr('data-method', data['method'])
		$('#modal-confirmation').modal('show');
	}
}

//function to set confirmation modal type ased on requested http method
function confirmationModalType(type)
{
	var text = {};
	switch (type.toLowerCase()){
		case 'delete' :
			text = { 'alert' : 'danger', 'confirm' : 'Are you sure?', 'button' : 'Delete' }
		break;
	}
	return text;
}

//function to create an ambiance notification
function notify(notification)
{
	$.ambiance({
        message: notification['message'],
        title: notification['title'],
        type: notification['type'],
        timeout: notification['timeout']
    });
}

//function to show loading message
function loading(data)
{
	if (data['show'])
	{
		$('.ajax-loading .message').text(data['message']);
		$('.ajax-loading').show();
	}
	else
	{
		$('.ajax-loading').hide();	
	}	
}

//function to update datatable entries info
function datatableUpdateEntriesInfo()
{
	var info=$('#table-result_info');
	var raw = info.text().split(' ');
	var text = 'Showing '+ parseInt(raw[5]-1) > 0 ? raw[1] : 0 +' to '+ parseInt(raw[3]-1) +' of '+ parseInt(raw[5]-1) +' Entries ';
	info.text(text);
}

//function to get typeahead datasets on html and return json data
function getAvalaibleAutocomplete(id)
{
	var auto = $('#'+id).parents('form').find('.autocomplete #autocomplete-avalaible-'+id);
	var data = [];
	if (auto.length > 0)
	{
		data = auto.text().length > 0 ? JSON.parse(auto.text()) : [] ;
	}
	return data;
}

//function to get existing autocomplete
function getPrePopulateAutocomplete(id)
{
	var auto = $('#'+id).parents('form').find('.autocomplete #autocomplete-prepopulate-'+id);
	var data = [];
	if (auto.length > 0)
	{
		data = auto.text().length > 0 ? JSON.parse(auto.text()) : [] ;
	}
	return data;
}

function initAutocomplete(element)
{
	var hint = element.attr('placeholder');
	element.tokenInput(getAvalaibleAutocomplete(element.attr('id')),
  	{
  	  prePopulate: getPrePopulateAutocomplete(element.attr('id')),
      searchDelay: 500,
      minChars: 1,
      preventDuplicates: true,
      hintText: hint,
      theme: 'facebook'
	});
	$(".token-input-dropdown-facebook").css("z-index","9999");
}

function submitModalForm(submit)
{
	var modal = $(submit).parents('.modal'),
		form = modal.find('form#'+$(submit).attr('data-target')),
	 	method = form.attr('method'),
	 	url = form.attr('action'),
	 	process = false,
	 	content = false,
	 	data = data = new FormData(form[0]);;

	$.ajax({
		dataType: 'json',
		url: url,
		type: method,
		data: data,
		processData: process,
    	contentType: content,
		error:function(request)
		{
			if (request.status == 422)
			{
				var response = request.responseJSON;
				//append validation input
				removeError(form);
				appendError(form, 'input', response);
				appendError(form, 'select', response);
			}
			else
			{
				modal.modal('hide');
			}
		},
		success:function(request)
		{
	      if ($('#table-result').length && form.hasClass('update-data-table'))
	      {
	      	 reloadDataTable($('#table-result'));
	      }

	      if (  modal.attr('id').toLowerCase() === 'modal-edit-profile')
	      {
	      	changeAvatar(request);
	      }

	      if (modal.hasClass('new-object'))
	      {
	      	modal.find('input').val('');
	      	modal.find('select').val('');
	      }

	      clearPasswordFields(form);
	      clearErrorsValidation(form);

	      notify({ 'type' : 'success', 'title' : 'Success', 'message' : modal.find('span.notify-success-text').text(), 'timeout' : 5 });
    	  modal.modal('hide');
    	}
	});
}

function removeError(form)
{
	form.find('div.form-group').removeClass('has-error');
	form.find('span.help-inline').text('');
}

function appendError(form,input_type,response)
{
	form.find(input_type).each(function(){
		if (response.hasOwnProperty($(this).attr('name')))
		{
			$(this).parents('div.form-group').addClass('has-error');
			$(this).parents('div.form-group').find('span.help-inline').text(response[$(this).attr('name')]);
		}
	});
}

function reloadDataTable(table)
{
	if (table.hasClass('dataTable'))
	{
		table.dataTable();
		table.fnClearTable( 0 );
  		table.fnDraw();		
	}
}

function changeAvatar(user)
{
	var avatar = $('nav').find('#current-user-avatar');
	var url = user.avatar_url;
	if (avatar.length)
	{
		avatar.attr('src', url);
		avatar.parents('a.dropdown-toggle').find('span').text(user.username);
	}
}

function initializeFileInput(input,options)
{
  input.fileinput(
  	options
  );
}

function newModalForm(event,element)
{
	var url = $(element).attr('href'),
		targetModal = $(element).attr('data-target'),
		currentModal,
		newForm = $(element).hasClass('new-object') ? true : false;

	if ( !$('#modal').find('div#'+targetModal).length )
	{
		$.ajax({
			dataType: 'json',
			url: url,
			type: 'get',
			success: function(request)
			{
				$('#modal').append(request);
				currentModal = $('#modal .modal').last();
				currentModal.attr('id', targetModal);

				//check if form's inputs has token-autocomplete class
				currentModal.find('.token-autocomplete').each(function(){
					initAutocomplete($(this));
				});
				
				//add target attr to submit button
				currentModal.find('.submit-modal-form').attr('data-target', ''+currentModal.find('form').attr('id'));
				if (newForm) currentModal.addClass('new-object');
				currentModal.modal('show');
			}
		});
	}else
	{
		$('#modal div#'+targetModal).modal('show');
	}
	event.preventDefault();
	return false;
}

function clearPasswordFields(form)
{
  form.find('input[type=password]').each(function(){
  	 $(this).val(''); 
  });
}

function clearErrorsValidation(form)
{
	form.find('div.form-group').each(function(){
		$(this).find('.help-inline').text('');
		$(this).hasClass('has-error') ? $(this).removeClass('has-error') : $(this);
	});
}

function initSelectize(element, options )
{
	element.selectize(options);	
}

function provideManufacture(form, car)
{
	car = car[0].selectize;      
  	car.on('item_add', function(value){
        var currentOption = car.getOption(value);
        if ( !currentOption.parents('div.optgroup').length )
        {
            form.find('.manufacture-input').removeClass('hidden'); 
        }
        else
        {
            form.find('.manufacture-input').addClass('hidden');
        }
  	});
}

//all event listeners are declared here

$(document).ready(function(event){
	//listen to confirmation
	$(".confirmation-button").click(function(e){
		var url = $(this).attr('data-href');
		var rowLink = $(this).attr('data-target');
		var method = $(this).attr('data-method');
		$.ajax({
			dataType : 'json',
			url : url,
			type : method,
			success: function(request)
			{
				if (method.toLowerCase() == 'delete')
				{
					if (rowLink !== undefined)
					{
						//remove row containing record 
						$('#'+rowLink).parents('tr').remove();
						//update datatable info entries
						datatableUpdateEntriesInfo();
						notify({ 'type' : 'success', 'message' : 'record deleted.', 'title' : 'Notice'});
					}
				}
			}
		});
		e.preventDefault();
		return false;
	});

	//to submit form
	$('.submit-form').click(function(e){
		if ($(this).attr('data-target') !== undefined)
		{
			$('#'+$(this).attr('data-target')).submit();
		}
		return false;
	});

	//jquery autocomplete
	$('body').find('.token-autocomplete').each(function(e){
		var inputId = $(this).attr('id');
		var hint = $(this).attr('placeholder');
		$(this).tokenInput(getAvalaibleAutocomplete(inputId),
		  	{
		  	  prePopulate: getPrePopulateAutocomplete(inputId),
		      searchDelay: 500,
		      minChars: 1,
		      preventDuplicates: true,
		      hintText: hint,
		      theme: 'facebook'
    		});

	});

	$('.new-modal-form').click(function(e)
	{
		newModalForm(e,this);	
	});
});

