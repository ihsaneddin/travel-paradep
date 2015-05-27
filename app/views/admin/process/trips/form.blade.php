@section('style-head')
    @parent
    <link href="{{asset('assets/plugins/datatables/media/DT_bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables/media/dataTables.responsive.css')}}" rel="stylesheet">
@stop

@section('script-end')
    @parent
    <script type="text/javascript" src="{{asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>

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

              <div class="form-group {{ Helpers::inputError($errors, 'departure_time') }}">
               {{ Form::label('departure_time', 'Departure Time', array('class' => 'col-md-2 control-label')) }}
                <div class="input-group col-md-10 date input-datetime " data-date="{{ $trip->departure_time }}" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="departure_time">
                    {{ Form::text('', is_null($trip->departure_time) ? '' : $trip->departure_time , array('class' => 'form-control')) }}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                 <span class='help-inline'>
                    {{ $errors->first('departure_time') }}
                  </span>
                {{ Form::hidden('departure_time', null, array('id' => 'departure_time')) }}
              </div>

              <div class="form-group {{ Helpers::inputError($errors, 'arrival_time') }}">
               {{ Form::label('departure_time', 'Departure Time', array('class' => 'col-md-2 control-label')) }}
                <div class="input-group col-md-10 date input-datetime " data-date="{{$trip->arrival_time}}" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="arrival_time">
                    {{ Form::text('', is_null($trip->arrival_time) ? '' : $trip->arrival_time , array('class' => 'form-control')) }}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <span class='help-inline'>
                  {{ $errors->first('arrival_time') }}
                </span>
                {{ Form::hidden('arrival_time', null, array('id' => 'arrival_time')) }}
              </div>

            </div>
        </div>
      </div>

      <div class="col-md-6" id="trip-input-options">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h5 class="panel-title pull-left">Select Options</h5>
                <div class="pull-right panel-action">


                      <ul class=" pull-right nav nav-tabs">
                          <li>
                            <a href="#trip-select-route" data-toggle="tab" data-target="#trip-select-route">Route</a>
                          </li>
                          <li>
                            <a href="#trip-select-driver" data-toggle="tab" data-target='#trip-select-driver'>Driver</a>
                          </li>
                          <li>
                            <a href="#trip-select-car" data-toggle="tab" data-target='#trip-select-car'>Car</a>
                          </li>
                      </ul>

                </div>
          </div>
          <div class="clearfix"></div>

          <div class="panel-body tab-content" style="height:150px" id="panelScroll">

            <div class="shadow shadow-top"></div>

              <div id="trip-select-route" class="tab-pane active">
                <table class="table">
                  <thead>
                    <tr>
                      <th>
                        Name
                      </th>
                      <th>
                        Code
                      </th>
                      <th>
                        Departure
                      </th>
                      <th>
                        Destination
                      </th>
                      <th>&nbsp</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($options['all_routes'] as $route)
                      <tr class=" {{ $trip->route_id == $route['id'] ? 'warning' : '' }}">
                        <td>{{ $route['name'] }}</td>
                        <td>{{ $route['code'] }}</td>
                        <td>{{ $route['departure_station'] }}</td>
                        <td>{{ $route['destination_station'] }}</td>
                        <td>
                          <a href="#" class="select-trip-option" data-target="#route_id" data-value="{{ $route['id'] }}" {{ $trip->route_id == $route['id'] ? 'disabled=""' : '' }}>
                            <i class="icon {{ $trip->route_id == $route['id'] ? 'icon-ok' : 'icon-check' }}"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div id="trip-select-driver" class="tab-pane">
                <table class="table">
                  <thead>
                    <tr>
                      <th>
                        Name
                      </th>
                      <th>
                        Code
                      </th>
                      <th>
                        Status
                      </th>
                      <th>&nbsp</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($options['all_drivers'] as $driver)
                      <tr class=" {{ $trip->driver_id == $driver['id'] ? 'warning' : '' }}">
                        <td>{{ $driver['name'] }}</td>
                        <td>{{ $driver['code'] }}</td>
                        <td>{{ $driver['state'] }}</td>
                        <td>
                          <a href="#" class="select-trip-option" data-target="#driver_id" data-value="{{ $driver['id'] }}" {{ $trip->driver_id == $driver['id'] ? 'disabled=""' : '' }}>
                            <i class="icon {{ $trip->driver_id == $driver['id'] ? 'icon-ok' : 'icon-check' }}"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div id="trip-select-car" class="tab-pane">
                <table class="table">
                  <thead>
                    <tr>
                      <th>
                        Code
                      </th>
                      <th>
                        Model
                      </th>
                      <th>
                        Class
                      </th>
                      <th>
                        Seat
                      </th>
                      <th>
                        Status
                      </th>
                      <th>&nbsp</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($options['all_cars'] as $car)
                      <tr class=" {{ $trip->travel_car_id == $car['id'] ? 'warning' : '' }}">
                        <td>{{ $car['code'] }}</td>
                        <td>{{ $car['merk'] }}</td>
                        <td>{{ $car['class'] }}</td>
                        <td>{{ $car['seat'] }}</td>
                        <td>{{ $car['state'] }}</td>
                        <td>
                          <a href="#" class="select-trip-option" data-target="#travel_car_id" data-value="{{ $car['id'] }}" {{ $trip->route_id == $car['id'] ? 'disabled=""' : '' }}>
                            <i class="icon {{ $trip->travel_car_id == $car['id'] ? 'icon-ok' : 'icon-check' }}"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>

        </div>
      </div>
    </div>

  <span class='notify-success-text hidden'> Route is successfully {{$trip->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}

<script>
    $(document).ready(function(){

      function updateTableSelectOption(value,select)
      {
        var table = $(select.attr('data-table')),
            chosen = table.find('tbody > tr > td > a.select-trip-option[data-value='+value+']');
        change_select_trip_options(chosen, false);
      }

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

      $('.table').DataTable({
        'bInfo': false,
        "bLengthChange": false,
        "bPaginate": false
      });


      $(document).on('click', '.select-trip-option', function(e){
        change_select_trip_options($(this),true);
      });

      function change_select_trip_options(chosen, update)
      {
        var tr = chosen.parents('tr'),
            tbody = chosen.parents('tbody'),
            i = chosen.find('i');
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

    });
</script>