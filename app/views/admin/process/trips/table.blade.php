<div id="boxCrud">
    <div class="table-responsive">
        <table class="table datatable table-striped table-condensed table-middle">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Route</th>
                    <th>Class</th>
                    <th>Driver</th>
                    <th>Car Code</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Status</th>
                    <th class="ac">Action</th>
                </tr>
            </thead>
            <tbody>

                {{ empty_table($trips->isEmpty(), 10, 'No trip(s) is found') }}

                @foreach($trips as $trip)

                <tr>
                    <td>
                        {{ $trip->code }}
                    </td>
                    <td>
                        {{ $trip->route->code }}
                    </td>
                    <td>
                        <span class="btn btn-xs btn-warning" disabled="">{{ ucwords($trip->route->category->name) }}</span>
                    </td>
                    <td>
                        {{ $trip->driver->code }}
                    </td>
                    <td>
                        {{ $trip->car->code }}
                    </td>
                    <td>
                        {{ $trip->route->departure_station }}
                    </td>
                    <td>
                        {{ $trip->route->destination_station }}
                    </td>
                    <td>
                        {{ $trip->departure_time }}
                    </td>
                    <td>
                        {{ $trip->arrival_time }}
                    </td>
                    <td>
                        {{ $trip->status }}
                    </td>
                    <td>
                        <div class="btn-group action">
                            {{Helpers::link_to('admin.process.trips.show', '<i class="icon icon-folder-open"></i>', ['trips' => $trip->id ],[])}}
                            {{Helpers::link_to('admin.process.trips.edit', '<i class="icon icon-edit"></i>', ['trips' => $trip->id ],[])}}
                        </div>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>
    </div>
</div>

<div class="box-pagination ac">
    {{ $trips->appends(Input::all())->links() }}
</div>
