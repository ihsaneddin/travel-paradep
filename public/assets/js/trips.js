function change_select_trip_options(chosen, update)
{
  if (update)
  {
    select = $(chosen.data('target'));
    selectize = $(chosen.data('target')).selectize({ create: false,
                                                  onChange: function(value){
                                                  updateTableSelectOption(value,select)}
                                                })
    selectize = select[0].selectize;
    selectize.setValue(chosen.attr('data-value'));
  }
}

function update_button_selected(chosen)
{
  var tr = chosen.parents('tr'),
      tbody = chosen.parents('tbody'),
      i = chosen.find('i');
  tbody.find('tr').removeClass('warning');
  tbody.find('.select-trip-option').find('i').each(function(){
    if ($(this).hasClass('icon-ok'))
    {
      $(this).removeClass('icon-ok');
      $(this).addClass('icon-check');
    }
  });
  i.removeClass('icon-check');
  i.addClass('icon-ok');
  tr.addClass('warning');
}

function update_trip_per(element)
{
  var url = element.data('url'),
      method = element.data('method'),
      field = element.data('field'),
      value = element.data('value'),
      data = {};
  data[field] = value;
  $.ajax({
    dataType: 'json',
    url: url,
    type: method,
    data: data,
    success: function(request)
    {
      var trip = request,
          table = $(element.data('update-list-table')),
          data = element.data('table')

      update_button_selected(element);
      update_selected_list_table(table, trip[data]);
    }
  });
}

function updateTableSelectOption(value,select)
{
  var table = $(select.attr('data-table')),
      chosen = table.find('tbody > tr > td > a.select-trip-option[data-value='+value+']');
  change_select_trip_options(chosen, false);
  update_button_selected(chosen);
}

$(document).ready(function(){

  $('form#trip-form').each(function(){
    var form =$(this);
    form.find('select').each(function(){
      if ( !$(this).hasClass('selectized') )
      {
        var select = $(this);
        initSelectize($(this), {create:false,
                                onChange: function(value){
                                  updateTableSelectOption(value,select)}
                                });
      }
    });
  });

  $('form#trip-form .table').DataTable({
    'bInfo': false,
    "bLengthChange": false,
    "bPaginate": false
  });


  $(document).on('click', '.select-trip-option', function(e){
    if ($('form#trip-form').length)
    {
      change_select_trip_options($(this),true);
    }
    else{
      update_trip_per($(this));
    }
  });

  $(document).on('click', '.edit-trip-detail', function(e){
    var chosen = $(this),
        modal = $(chosen.attr('href')),
        table = modal.find('table.table');
    modal.modal('show');
    table.each(function(){
      if (!table.hasClass('datatable-initialized'))
      {
        var data_list_update_table = chosen.data('update-list-table'),
            data_table = chosen.data('table');
        table.find('a.select-trip-option').each(function(){
          $(this).attr('data-update-list-table', data_list_update_table);
          $(this).attr('data-table', data_table);
        });
        $(this).DataTable({
          'bInfo': false,
          "bLengthChange": false,
          "bPaginate": false
        });
        $(this).addClass('datatable-initialized');
      }

    });
    e.preventDefault();

  });

});