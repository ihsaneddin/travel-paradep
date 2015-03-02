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
		notify({ 'type' : 'error', 'title' : 'Error', 'message' : 'Your request can not be processed right now.', 'timeout' : 0 });
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
	var form = $('#modal-admin form'+$(submit).attr('data-target'));
	var method = form.attr('method');
	var url = form.attr('action');
	var data = form.serialize();
	$.ajax({
		dataType: 'json',
		url: url,
		type: method,
		data: data,
		error:function(request)
		{
			if (request.status == 422)
			{
				var response = request.responseJSON;
				form.find('input').each(function(e){
					if (response.hasOwnProperty($(this).attr('name')))
					{
						$(this).parents('div.form-group').addClass('has-error');
						$(this).parents('div.form-group').find('span.help-inline').text(response[$(this).attr('id')]);
					} 
				});
			}
			else
			{
				$('#modal #modal-admin').modal('hide');
			}
		},
		success:function(request)
		{
	      var table = $('#table-result').dataTable();
	      table.fnClearTable( 0 );
	      table.fnDraw();
	      $('#modal-admin').modal('hide');
	      $('#modal-admin').removeClass('filled');
	      notify({ 'type' : 'success', 'title' : 'Success', 'message' : 'Record is succesfuly created.', 'timeout' : 10 });
    	}
	});
}

function appendNewRecordToTable(record)
{
  var table = $('div.table-responsive');
  var displayRow = parseInt($('#table-result_length').find('select').val());
  if (table.length)
  {
      var rowCount = table.find('tbody > tr').length;
      var newRowData = newRowData(table.attr('id'), record);
      var td = '';
      newRowData.each(function(row){
        
      });  
  }

}

function newRowData(type,record)
{
  var row = {};
  switch(type)
  {
    case 'users-table':
        row = { 'username' : record['username'], 'email' : record['email'], 'roles' : 'roles', 'last_login' : record['last_login'], 'action' : actionColumn(type,record) }
  }
  return row;
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

	$('.new-record-modal').click(function(e)
	{
		var url = $(this).attr('href');
		if (!$('#modal-admin').hasClass('filled'))
		{
			$.ajax({
				dataType: 'json',
				url: url,
				type: 'get',
				success: function(request)
				{
					$('#modal').html(request);
					//check if form's inputs has token-autocomplete class
					$('#modal-admin form').find('.token-autocomplete').each(function(){
						initAutocomplete($(this));
					});
					
					//add class flag to modal
					$('#modal-admin').addClass('filled');
					//add target attr to submit button
					$('#modal-admin .submit-modal-form').attr('data-target', '#'+$('#modal-admin form').attr('id'));
					$('#modal-admin').modal('show');
				}
			});
		}else
		{
			$('#modal-admin').modal('show');
		}
		e.preventDefault();
		return false;
	});
});

