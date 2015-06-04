<div id="boxCrud">
    <div class="table-responsive">
        <table class="table datatable table-striped table-condensed table-middle" id="table-bookings-index">
            <thead>
                <tr>
                    <th data-attribute="code">Code</th>
                    <th data-attribute="passenger.name">Name</th>
                    <th data-attribute="passenger.phone">Phone No</th>
                    <th data-attribute="seat_no">Seat No</th>
                    <th data-attribute="trip.route.departure_station">Departure</th>
                    <th data-attribute="trip.route.destination_station">Destination</th>
                    <th data-attribute="trip.departure_time">Departure Time</th>
                    <th data-attribute="trip.arrival_time">Arrival Time</th>
                    <th data-attribute="payment_status">Status</th>
                    <th class="ac" data-attribute="action" data-action-cancel="<a href='{{route('admin.process.trips.bookings.cancel',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs '><i class='icon icon-remove-sign'></i></a>"  data-action-payment="<a href='{{route('admin.process.trips.bookings.payment',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs '><i class='icon icon-usd'></i></a>">Action</th>
                </tr>
            </thead>
            <tbody>

                {{ empty_table($bookings->isEmpty(), 10, 'No booking(s) is found') }}

                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->code }}</td>
                            <td>{{ $booking->passenger->name }}</td>
                            <td>{{ $booking->passenger->phone }}</td>
                            <td>{{ $booking->seat_no }}</td>
                            <td>{{ $booking->trip->route->departure_station }}</td>
                            <td>{{ $booking->trip->route->destination_station }}</td>
                            <td>{{ $booking->trip->departure_time }}</td>
                            <td>{{ $booking->trip->arrival_time }}</td>
                            <td>{{ $booking->payment_status }}</td>
                            <td>
                                <div class="btn-group action">
                                    <a href="{{ route('admin.process.bookings.show',array('bookings' => $booking->id)) }}" class="btn btn-default btn-xs new-modal-form"  data-target="modal-show-booking-{{ $booking->id }}"><i class="icon icon-folder-open"></i></a>
                                    <a href="{{ route('admin.process.trips.bookings.cancel',array('trips' => $booking->trip_id,'bookings' => $booking->id)) }}" class="btn btn-default btn-xs confirm" data-method="put" ><i class="icon icon-remove-sign"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="box-pagination ac">
    {{ $bookings->appends(Input::all())->links() }}
</div>
