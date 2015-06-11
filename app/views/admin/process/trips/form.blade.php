@section('style-head')
    @parent
    <link href="{{asset('assets/plugins/datatables/media/DT_bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables/media/dataTables.responsive.css')}}" rel="stylesheet">
@stop

@section('script-end')
    @parent
    <script type="text/javascript" src="{{asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/trips.js')}}"></script>
@stop

{{ Form::model($trip, ['route' => Helpers::createOrUpdateRoute($trip),
             'class' => 'form form-horizontal update-data-table form-trip box',
              'id' => 'trip-form', 'method' => Helpers::createOrUpdateMethod($trip)]) }}

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
               <h5 class="panel-title pull-left"> Basic Trip Information</h5>
            </div>

            <div class="panel-body">

              @if (is_null($trip->id))

                <div class="form-group {{ Helpers::inputError($errors, 'route_id') }}">
                  {{ Form::label('route_id', 'Route', array('class' => 'col-md-2 control-label')) }}
                  <div class="col-md-10">
                    {{ Form::select('route_id', $options['routes'], $trip->route_id,
                                  array('class' => 'form-control', 'id' => 'route_id', 'data-table' => '#trip-select-route')) }}
                    <span class='help-inline'>
                      {{ $errors->first('route_id') }}
                    </span>
                  </div>
                </div>

              @endif

              <div class="form-group {{ Helpers::inputError($errors, 'driver_id') }}">
                {{ Form::label('driver_id', 'Driver', array('class' => 'col-md-2 control-label')) }}
                <div class="col-md-10">
                  {{ Form::select('driver_id', $options['drivers'], $trip->driver_id,
                                array('class' => 'form-control', 'id' => 'driver_id', 'data-table' => '#trip-select-driver')) }}
                  <span class='help-inline'>
                    {{ $errors->first('driver_id') }}
                  </span>
                </div>
              </div>

              <div class="form-group {{ Helpers::inputError($errors, 'travel_car_id') }}">
                {{ Form::label('travel_car_id', 'Car', array('class' => 'col-md-2 control-label')) }}
                <div class="col-md-10">
                  {{ Form::select('travel_car_id', $options['cars'], $trip->travel_car_id,
                                array('class' => 'form-control', 'id' => 'travel_car_id', 'data-table' => '#trip-select-car')) }}
                  <span class='help-inline'>
                    {{ $errors->first('travel_car_id') }}
                  </span>
                </div>
              </div>

              <div class="form-group {{ Helpers::inputError($errors, 'quota') }}">
                {{ Form::label('quota', 'Quota', array('class' => 'col-md-2 control-label')) }}
                <div class="col-md-10">
                  {{ Form::selectRange('quota', 8,20, $trip->quota,
                                array('class' => 'form-control', 'id' => 'quota')) }}
                  <span class='help-inline'>
                    {{ $errors->first('quota') }}
                  </span>
                </div>
              </div>

              <div class="form-group {{ Helpers::inputError($errors, 'departure_date') }} {{ Helpers::inputError($errors, 'departure_hour') }}">
               {{ Form::label('departure_date', 'Departure Date', array('class' => 'col-md-2 control-label')) }}
                <div class="col-md-6 ">
                  <div class="input-group date input-datetime-only-date update-the-hour" data-date="{{ format_date_time($trip->departure_date, 'd M Y') }}" data-date-format="dd MM yyyy" data-link-field="dummoy_departure_date" data-hour-target=".input-datetime-only-hour">
                      {{ Form::text('departure_date', is_null($trip->departure_date) ? '' : format_date_time($trip->departure_date, 'd M Y'), array('class' => 'form-control', 'id' => 'departure_date')) }}
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                  <span class='help-inline'>
                    {{ $errors->first('departure_date') }}
                  </span>
                </div>

                <div class="col-md-4">
                  <div class="input-group date input-datetime-only-hour" data-date="{{ $trip->departure_hour }}" data-date-format="hh:ii" data-link-field="dummy_departure_hour">
                    {{ Form::text('departure_hour', is_null($trip->departure_hour) ? '' : $trip->departure_hour , array('class' => 'form-control', 'id' => 'departure_hour')) }}
                      <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                  </div>
                  <span class='help-inline'>
                    {{ $errors->first('departure_date') }}
                  </span>
                </div>
              </div>

            </div>
        </div>
      </div>

      @include('admin.process.trips.options', array('options' => $options))

    </div>

  <span class='notify-success-text hidden'> Trip is successfully {{$trip->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}
