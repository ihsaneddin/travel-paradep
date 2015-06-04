{{ Form::open(['class' => 'form mb clearfix form-filter',
              'id' => 'trips-search', 'method' => 'get', 'role' => 'form']) }}
    <div class="form-group">
        <div class="col-sm-6 pad-zero">
             {{Form::text('filter[code]',
                     Input::get('filter.code'),
                     ['class' => 'form-control', 'placeholder' => 'Search code']) }}
        </div>
        <div class="col-sm-2">
            {{ Form::submit('Search', array('class' => 'btn btn-default btn-block submit-form-filter')) }}
        </div>
        <div class="col-sm-2 pad-zero">
            <a href="#" class="btn btn-link" id="btnToggleAdvanceSearch">Advance Search</a>
        </div>
    </div>
{{ Form::close() }}

{{ Form::open(['class' => 'form form-horizontal clearfix hide well form-filter',
              'id' => 'formAdvanceSearch', 'method' => 'get', 'role' => 'form']) }}

    <div class="col-sm-6">

      <div class="form-group">
        {{ Form::label('filter[route][code]', 'Route Code', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[route][code]', $options['routes'], Input::get('filter.route.code'),
                        array('class' => 'form-control', 'id' => 'filter[route][code]')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[route][class]', 'Class', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[route][class]', $options['categories'], Input::get('filter.route.class'),
                        array('class' => 'form-control', 'id' => 'filter[route][class]')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[driver][code]', 'Driver code', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[driver][code]', $options['drivers'], Input::get('filter.driver.code'),
                        array('class' => 'form-control', 'id' => 'filter[driver][code]')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[car][code]', 'Car code', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[car][code]', $options['cars'], Input::get('filter.car.code'),
                        array('class' => 'form-control', 'id' => 'filter[car][code]')) }}
        </div>
      </div>

    </div>

    <div class="col-sm-6">

      <div class="form-group">
        {{ Form::label('filter[route][departure]', 'Departure', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[route][departure]', $options['stations'], Input::get('filter.route.departure'),
                        array('class' => 'form-control', 'id' => 'filter[route][departure]')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[route][destination]', 'Destination', array('class' => 'col-sm-3 control-label')) }}
        <div class="col-sm-9">
          {{ Form::select('filter[route][destination]', $options['stations'], Input::get('filter.route.destination'),
                        array('class' => 'form-control', 'id' => 'filter[route][destination]')) }}
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[departure_date]', 'From Date', array('class' => 'col-sm-3 control-label')) }}
        <div class="input-group col-sm-5 date input-datetime-only-date update-the-hour" data-date="{{ format_date_time(Input::get('filter.from_departure_date'), 'd M Y') }}" data-date-format="dd MM yyyy" data-link-field="dummy_from_departure_date" data-hour-target=".input-datetime-only-hour">
            {{ Form::text('filter[from_departure_date]', format_date_time(Input::get('filter.from_departure_date'), 'd M Y')  , array('class' => 'form-control', 'id' => 'filter[from_departure_date]')) }}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <div class="input-group col-sm-4 date input-datetime-only-hour " data-date="{{ Input::get('from_filter.departure_hour') }}" data-date-format="hh:ii" data-link-field="dummy_from_departure_hour">
            {{ Form::text('filter[from_departure_hour]', Input::get('filter.from_departure_hour') , array('class' => 'form-control', 'id' => 'filter[from_departure_hour]')) }}
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
      </div>

      <div class="form-group">
        {{ Form::label('filter[to_departure_date]', 'To Date', array('class' => 'col-sm-3 control-label')) }}
        <div class="input-group col-sm-5 date input-datetime-only-date update-the-hour" data-date="{{ format_date_time(Input::get('filter.from_departure_date'), 'd M Y') }}" data-date-format="dd MM yyyy" data-link-field="to_departure_date" data-hour-target=".input-datetime-only-hour">
            {{ Form::text('filter[to_departure_date]', format_date_time(Input::get('filter.to_departure_date'), 'd M Y') , array('class' => 'form-control', 'id' => 'filter[to_departure_date]')) }}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <div class="input-group col-sm-4 date input-datetime-only-hour " data-date="{{ Input::get('filter.to_departure_hour') }}" data-date-format="hh:ii" data-link-field="to_departure_hour">
            {{ Form::text('filter[to_departure_hour]', Input::get('filter.to_departure_hour') , array('class' => 'form-control', 'id' => 'filter[to_deparute_hour]')) }}
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
      </div>

    </div>

    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4 ">
                {{ Form::submit('Search', array('class' => 'btn btn-block btn-warning submit-form-filter ', 'value' => 'search')) }}
            </div>
        </div>
    </div>

{{ Form::close() }}

<script>
    $(document).ready(function(){

      $('form#formAdvanceSearch').each(function(){
        var form =$(this);
        form.find('select').each(function(){
          if ( !$(this).hasClass('selectized') )
          {
            initSelectize($(this), {create:false});
          }
        });
      });
    });
</script>