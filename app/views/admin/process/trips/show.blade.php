@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($trip)}}
@stop

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

@section('content')

    <div class="box">
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                  <h2 class="panel-title pull-left">Trip Details</h2>
                  <div class="pull-right panel-action">
                      <div class="btn-group">

                        <a href="{{route('admin.process.trips.bookings.create', array('trips' => $trip->id))}}" class="btn btn-default new-modal-form new-object" data-target= "modal-new-trip-{{$trip->id}}-booking" >
                          <i class="icon icon-plus"></i> New Booking
                        </a>

                        {{Helpers::link_to('admin.process.trips.ready', 'Ready', ['trips' => $trip->id],['class' => 'btn btn-info confirm change-state', 'data-method' => 'put', 'id' => 'trip-ready-'.$trip->id, 'data-confirmation-message' => 'This will change trip state to <b>ready</b>. Are you sure?' ])}}
                        {{Helpers::link_to('admin.process.trips.depart', 'Depart', ['trips' => $trip->id],['class' => 'btn btn-warning confirm change-state', 'data-method' => 'put', 'id' => 'trip-depart-'.$trip->id, 'data-confirmation-message' => 'This will change trip state to <b>on trip</b>. Are you sure?' ])}}
                        {{Helpers::link_to('admin.process.trips.cancel', 'Cancel', ['trips' => $trip->id],['class' => 'btn btn-danger confirm change-state', 'data-method' => 'put', 'id' => 'trip-cancel-'.$trip->id, 'data-confirmation-message' => 'Be careful! This action will cancel the trip. Are you sure?' ])}}
                        {{Helpers::link_to('admin.process.trips.arrive', 'Arrive', ['trips' => $trip->id],['class' => 'btn btn-success confirm change-state', 'data-method' => 'put', 'id' => 'trip-arrive-'.$trip->id, 'data-confirmation-message' => 'Trip has arrived at destination.' ])}}
                        {{Helpers::link_to('admin.process.trips.edit', '<i class="icon icon-pencil"></i>', ['trips' => $trip->id],['class' => 'btn btn-default'])}}

                      </div>
                  </div>
              </div>
              <div class="panel-body">

                <div class="col-md-12">
                   <dl class="dl-horizontal">
                      <dt>Code</dt>
                      <dd>: {{ $trip->code }}</dd>
                      <dt>Status</dt>
                      <dd>: {{ $trip->pretty_state }}</dd>
                      <dt>Departure Time</dt>
                      <dd>: {{ format_date_time($trip->departure_date, 'M d Y') }}, {{ format_date_time($trip->departure_hour, 'H:i') }}</dd>
                      <dt>Arrival Time</dt>
                      <dd>: {{ format_date_time($trip->arrival_date, 'M d Y') }}, {{ format_date_time($trip->arrival_hour, 'H:i') }}</dd>
                      <dt>Duration</dt>
                      <dd>: {{ $trip->durations }}</dd>
                      <dt>Quota</dt>
                      <dd>: {{ $trip->quota_status }}</dd>
                      <dt>Class</dt>
                      <dd>: <button class="btn btn-warning btn-xs" disabled="">{{ ucwords($trip->route->category->name) }}</button></dd>
                  </dl>

                  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title pull-left">Route Details</h2>
                    </div>
                    <div class="panel-body">
                      <table class="table">
                        <thead>
                          <th>Code</th>
                          <th> Name</th>
                          <th>Class</th>
                          <th>Departure Station</th>
                          <th>Destination Station</th>
                        </thead>
                        <tbody>
                          <td>
                            {{ $trip->route->code }}
                          </td>
                          <td>
                            {{ $trip->route->name}}
                          </td>
                          <td>
                            <button class="btn btn-warning btn-xs" disabled="">{{ ucwords($trip->route->category->name) }}</button>
                          </td>
                          <td>
                            {{ $trip->route->departure_station }} ({{ $trip->route->departure->code }})
                          </td>
                          <td>
                            {{ $trip->route->destination_station }} ({{ $trip->route->destination->code }})
                          </td>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <h2 class="panel-title pull-left">Car Details</h2>
                        <div class="pull-right panel-action">
                            <div class="btn-group">
                            <a id="edit-car" href="#edit-car-modal" role="button" class="btn btn-default edit-trip-detail" data-update-list-table="#trip-car-table-list" data-table="car"><i class="icon icon-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                      <table class="table" id="trip-car-table-list">
                        <thead>
                          <th data-attribute="code">Code</th>
                          <th data-attribute="merk">Merk</th>
                          <th data-attribute="manufacture">Manufacture</th>
                          <th data-attribute="class">Class</th>
                          <th data-attribute="license_no">Police Number</th>
                          <th data-attribute="seat">Seat</th>
                        </thead>
                        {{ empty_table(is_null($trip->car), 4, 'No car is registered on this trip.') }}
                        <tbody>
                          @if (!is_null($trip->car))
                            <td> {{ $trip->car->code }}</td>
                            <td> {{ $trip->car->merk }}</td>
                            <td> {{ $trip->car->model->manufacture }}</td>
                            <td> {{ $trip->car->class }}</td>
                            <td> {{ $trip->car->license_no }}</td>
                            <td>  {{$trip->car->seat }} </td>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <h2 class="panel-title pull-left">Driver Details</h2>
                        <div class="pull-right panel-action">
                            <div class="btn-group">
                               <a id="edit-driver" href="#edit-driver-modal" role="button" class="btn btn-default edit-trip-detail" data-update-list-table="#trip-driver-table-list" data-table="driver"><i class="icon icon-pencil"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                      <table class="table" id="trip-driver-table-list">
                        <thead>
                          <th data-attribute='code'>Code</th>
                          <th data-attribute='name'>Name</th>
                          <th data-attribute='drive_hours'>Drive Hours</th>
                        </thead>
                        {{ empty_table(is_null($trip->driver), 3, 'No driver is registered on this trip.') }}
                        <tbody>
                          @if (!is_null($trip->driver))
                            <td> {{ $trip->driver->code }}</td>
                            <td> {{ $trip->driver->name }}</td>
                            <td> {{ $trip->driver->drive_hours }}</td>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading">
                     <h2 class="panel-title pull-left">Passengers List</h2>
                    </div>
                    <div class="panel-body">
                      <table class="table" id="trip-passengers-table-list" data-multiple="true">
                      <thead>
                        <th data-attribute="code">Code</th>
                        <th data-attribute="passenger.name">Name</th>
                        <th data-attribute="passenger.phone">Phone</th>
                        <th data-attribute="payment_status">Payment</th>
                        <th data-attribute="pretty_state">Status</th>
                        <th data-attribute="seat_no">Seat No</th>
                        <th data-attribute="action" data-action-cancel="<a id='change-booking-status-booking_id' href='{{route('admin.process.trips.bookings.cancel',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs confirm change-state' data-method='put'><i class='icon icon-remove-sign'></i></a>"  data-action-payment="<a id='change-booking-payment-status-booking_id'  href='{{route('admin.process.trips.bookings.payment',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs confirm change-state' data-method='put'><i class='icon icon-book'></i></a>" >Action</th>
                      </thead>
                      <tbody>
                      {{ empty_table($trip->bookings->isEmpty(), 6, 'No passenger is registered on this trip.') }}

                        @if (!is_null($trip->bookings()->active()))
                          @foreach($trip->bookings as $booking)
                            <tr>
                              <td>{{ $booking->code }}</td>
                              <td>{{ $booking->passenger->name }}</td>
                              <td>{{ $booking->passenger->phone }}</td>
                              <td>{{ $booking->payment_status }}</td>
                              <td>{{ $booking->pretty_state }}</td>
                              <td>{{ $booking->seat_no }}</td>
                              <td>
                                <div class="btn-group action">
                                  @if(!$booking->paid)
                                    <a id="change-booking-payment-status-{{ $booking->id }}" href="{{ route('admin.process.trips.bookings.payment', array('trips' => $booking->trip_id, 'bookings' => $booking->id)) }}" class="btn btn-xs confirm change-state" data-method="put" data-confirmation-message="Are you sure want to change this booking payment state to <b>paid</b> ?"><i class="icon icon-book"></i></a>
                                  @endif
                                  <a id="change-booking-status-{{ $booking->id }}" href="{{ route('admin.process.trips.bookings.cancel', array('trips' => $booking->trip_id, 'bookings' => $booking->id)) }}" class="btn btn-xs confirm change-state" data-method="put" data-confirmation-message="If you click yes, the booking will be <b>canceled</b>. Are you sure?"><i class="icon icon-remove-sign" ></i></a>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                    </div>
                  </div>

                </div>
              </div>
              <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>

@stop

@section('modal')
  @include('admin.process.trips.trip_edit_details_modal', array('trip' => $trip, 'options' => $options))
  @include('admin.shared.confirmation')
@stop