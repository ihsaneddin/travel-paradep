<div id="boxCrud">
    <div class="table-responsive">
        <table class="table datatable table-striped table-condensed table-middle" id="table-bookings-index">
            <thead>
                <tr>
                    <th data-attribute="code">Code</th>
                    <th data-attribute="passenger.name">Name</th>
                    <th data-attribute="passenger.phone">Phone No</th>
                    <th data-attribute="seat_no">Seat No</th>
                    <th data-attribute="trip.departure_time">Departure Time</th>
                    <th data-attribute="trip.arrival_time">Arrival Time</th>
                    <th data-attribute="payment_status">Payment</th>
                    <th data-attribute="pretty_state">Status</th>
                    <th data-attribute="action" data-action-cancel="<a id='change-booking-status-booking_id' href='{{route('admin.process.trips.bookings.cancel',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs confirm change-state' data-method='put'><i class='icon icon-remove-sign'></i></a>"  data-action-payment="<a id='change-booking-payment-status-booking_id'  href='{{route('admin.process.trips.bookings.payment',array('trips' => 'trip_id', 'bookings' => 'booking_id'))}}' class='btn btn-xs confirm change-state' data-method='put'><i class='icon icon-book'></i></a>"  data-action-show="<a href='{{ route('admin.process.bookings.show',array('bookings' => 'booking_id')) }}'' class='btn btn-default btn-xs new-modal-form' data-target='modal-show-booking-booking_id'><i class='icon icon-folder-open'></i></a>">Action</th>
                </tr>
            </thead>
            <tbody>

                {{ empty_table($bookings->isEmpty(), 10, 'No booking(s) is found') }}
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->code }}</td>
                        <td>{{ $booking->passenger->name }}</td>
                        <td>{{ $booking->passenger->phone }}</td>
                        <td>{{ $booking->seat_no }}</td>
                        <td>{{ $booking->trip->departure_time }}</td>
                        <td>{{ $booking->trip->arrival_time }}</td>
                        <td>{{ $booking->payment_status }}</td>
                        <td>{{ $booking->pretty_state }}</td>
                        <td>
                            <div class="btn-group action">
                                <a href="{{ route('admin.process.bookings.show',array('bookings' => $booking->id)) }}" class="btn btn-default btn-xs new-modal-form"  data-target="modal-show-booking-{{ $booking->id }}"><i class="icon icon-folder-open"></i></a>
                                @if(!$booking->paid)
                                    <a id="change-booking-payment-status-{{ $booking->id }}" href="{{ route('admin.process.trips.bookings.payment', array('trips' => $booking->trip_id, 'bookings' => $booking->id)) }}" class="btn btn-xs confirm change-state" data-method="put" data-confirmation-message="Are you sure want to change this booking payment state to <b>paid</b> ?"><i class="icon icon-book"></i></a>
                                @endif
                                <a id="change-booking-status-{{ $booking->id }}" href="{{ route('admin.process.trips.bookings.cancel', array('trips' => $booking->trip_id, 'bookings' => $booking->id)) }}" class="btn btn-xs confirm change-state" data-method="put" data-confirmation-message="If you click yes, the booking will be <b>canceled</b>. Are you sure?"><i class="icon icon-remove-sign" ></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="box-pagination ac">
    {{ $bookings->appends(Input::all())->links() }}
</div>
