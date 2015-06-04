@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($booking)}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.process.trips.bookings.form', ['booking' => $booking, 'options' => $options])

                    <div class="row">

                      <div class="form-group col-md-6">
                        {{ Form::label('trip_id', 'Trip Code', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('trip_code', $booking->trip->code,
                                        array('class' => 'form-control', 'id' => 'trip_code', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('route_code', 'Route Code', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('route_code', $booking->trip->route->code,
                                        array('class' => 'form-control', 'id' => 'route_code', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('departure_station', 'Departure Station', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('departure_station', $booking->trip->route->departure_station,
                                        array('class' => 'form-control', 'id' => 'departure_station', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('departure_time', 'Departure Time', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('departure_time', $booking->trip->departure_time,
                                        array('class' => 'form-control', 'id' => 'departure_time', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('destination_station', 'Destination Station', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('destination_station', $booking->trip->route->destination_station,
                                        array('class' => 'form-control', 'id' => 'destination_station', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('destination_time', 'Arrival Time', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('destination_time', $booking->trip->arrival_time,
                                        array('class' => 'form-control', 'id' => 'destination_time', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        {{ Form::label('durations', 'Durations', array('class' => 'col-md-2 control-label')) }}
                        <div class="col-md-10">
                          {{ Form::text('durations', $booking->trip->durations,
                                        array('class' => 'form-control', 'id' => 'durations', 'disabled' => 'disabled')) }}
                        </div>
                      </div>

                    </div>

                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='trip-form'>Submit</button>
                    {{link_to_route('admin.process.trips.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

