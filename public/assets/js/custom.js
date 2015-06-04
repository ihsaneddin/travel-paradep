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

//function to set confirmation modal type based on requested http method
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
	 	data = new FormData(form[0]);
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

	      if ($('select.station-options').length && $('form#route-form').length && ( form.attr('id') == 'station-form') )
	      {
	      	var i = 0,
	      		city = request.addresses[0].city,
	      		text = request.name,
	      		value = request.id;
	      	$('select.station-options').each(function(){
	      		$('select.station-options')[i].selectize.addOptionGroup(city, {label: city });
	      		$('select.station-options')[i].selectize.addOption({value: value,text: text, optgroup: city});
	      		i = i + 1;
	      	});
	      }

	      if  (form.data('update-list-table'))
	      {
	      	update_selected_list_table($('table'+form.data('update-list-table')),request);
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
	var avatar = $('nav').find('#current-user-avatar'),
		url = user.avatar_url;
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
				currentModal.find('form').attr('id', 'form-'+targetModal);
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

function paginate(element)
{
	var url = element.attr('href');
	 		$.ajax({
			dataType : 'json',
			url : url,
			type : 'get',
			success: function(request)
			{
				var container = $('div#table-index');
				if (container.length)
				{
					append_table_index(container,request);
					var pagination = $('div#table-index .box-pagination ul.pagination'),
						simple_container = $('div#simple-pagination');
					simple_paginate(simple_container, pagination);
				}
			}
		});
}

function simple_paginate(container, source_pagination)
{
	if (container.length)
	{
		var simple_next = container.find('a.simple-next'),
			simple_prev = container.find('a.simple-prev'),
			next_link = source_pagination.find('li a[rel=next]'),
			prev_link = source_pagination.find('li a[rel=prev]'),
			current_page = source_pagination.find('li.active span').text();
		next_link.length ? simple_next.attr('href', next_link.attr('href')) : simple_next.attr('href', '');
		prev_link.length ? simple_prev.attr('href', prev_link.attr('href')) : simple_prev.attr('href', '');
		container.find('a').each(function(){
			$(this).attr('href').length ? $(this).removeAttr('disabled') : $(this).attr('disabled', 'disabled');
		});
		current_page.length ? container.find('.current-page').text(current_page) : null ;

	}
}

function ajax_filter_index(form)
{
	var method = form.attr('method'),
	 	url = form.attr('action'),
	 	data = form.serialize();
	$.ajax({
		dataType: 'json',
		url: url,
		type: method,
		data: data,
    	error: function(request){
    		notify({ 'type' : 'error', 'message' : 'Something is not right. Please try again.', 'title' : 'Error'});
    	},
    	success: function(request){
    		var container = $('div#table-index');
    		append_table_index(container,request);
			var pagination =  container.find('.box-pagination ul.pagination'),
				simple_container = $('div#simple-pagination');
			simple_paginate(simple_container, pagination);
    	}
    });
}

function append_table_index(container, table)
{
	container.html(table);
}

function update_selected_list_table(table,data)
{
  var td = get_value_of_td(data, th_attributes(table)),
  	  tr = table.find('tbody tr:first');

  if (table.data('multiple'))
  {
  	append_tr(table,td,data);
  }
  else{
  	replace_tr(table,tr,td);
  }

}

function th_attributes(table)
{
	var attributes = [];
	table.find('th').each(function(){
    	attributes.push($(this).data('attribute'));
  	});
  	return attributes;
}

function get_value_of_td(data,attributes)
{
	var td = [];
	for (var i = 0; i < attributes.length; i++) {
	    var push = false,
	    	value,
	    	index = attributes[i].split('.'),
	    	actual_data = data;
	    for(var j=0; j < index.length; j++){
	    	actual_data = push ? value : actual_data;
	    	if (actual_data.hasOwnProperty(index[j]))
	    	{
	    		value = actual_data[index[j]];
	    		push = true;
	    	}
	    	if (index[j] == 'action')
	    	{
	    		value = 'action';
	    		push = true;
	    	}
	    }
	    if (push)
	    	td.push(value);
	 }
	 return td;
}

function replace_tr(table,tr,td)
{
	var i = 0;
	console.log(tr);
    tr.find('td').each(function(){
      $(this).text(td[i]);
      i++;
    });
}

function append_tr(table,td,data)
{
	var i = 0,
		_td = [];
	if (table.find('tr.no-record').length)
		table.find('tr.no-record').remove();
	table.find('thead th').each(function(){
		if (td[i] == 'action')
		{
			var th = table.find('th[data-attribute=action]');
			if (th.length)
			{
				_td.push('<td>'+set_action_button(th, data)+'</td>');
			}
		}else
		{
			_td.push('<td>'+td[i]+'</td>');
		}
		i++;
	});
	table.find('tbody:last-child').append('<tr>'+_td.join('')+'</tr>');

}

function set_action_button(th, data)
{
	var table = th.parents('table'),
		action_buttons = '';
	if ((table.attr('id') == 'trip-passengers-table-list') || (table.attr('id') == 'table-bookings-index') )
	{
		var cancel = th.data('action-cancel');
		if (cancel)
		{
			cancel = cancel.replace('trip_id', data.trip.id);
			cancel = cancel.replace('booking_id', data.id);
			action_buttons = action_buttons+' '+cancel;
		}
	}
	return action_buttons;

}

//all event listeners are declared here

$(document).ready(function(event){

	//simple pagination
	var simple_container = $('div#simple-pagination'),
		pagination = $('div#table-index .box-pagination ul.pagination');
	simple_paginate(simple_container,pagination);

	//generate confirmation

	$(document).on('click', '.confirm', function(e){
		var data = { 'href' : $(this).attr('href'), 'target' : $(this).attr('id'), 'method' : $(this).data('method')};
		confirmationModal(confirmationModalType('delete'),data);
		e.preventDefault();
		return false;

	});

	//listen to confirmation
	$(document).on('click', ".confirmation-button", function(e){
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

	$(document).on('click', '.new-modal-form', function(e)
	{
		newModalForm(e,this);
	});

	 $(function(){
            $('#pageCrud').on('click', '.btn-delete', function(){
                bootbox.confirm("Are you sure to delete this data?", function(result) {
                    if(result){
                        $('#panelCrud').block({message: 'Refreshing...'});
                        setTimeout(function(){$('#panelCrud').unblock()}, 2000);
                    }
                });
            });

            $('#btnToggleAdvanceSearch').on('click', function(){
                $('#formAdvanceSearch').toggleClass('hide');
            });
        });

	 $('#panelScroll').slimscroll();

	 $(document).on('click', '.box-pagination ul > li > a ', function(e){
	 	paginate($(this));
	 	e.preventDefault();
	 });

	 $(document).on('click', '.simple-paginate', function(e){
	 	paginate($(this));
	 	e.preventDefault();
	 });

	 $(document).on('click', '.submit-form-filter', function(e){
	 	var form = $(this).parents('form.form-filter');
	 	ajax_filter_index(form);
	 	e.preventDefault();
	 })

});

