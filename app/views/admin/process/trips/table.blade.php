<div id="boxCrud">
    <div class="table-responsive">
        <table class="table datatable table-striped table-condensed table-middle">
            <thead>
                <tr>
                    <th data-attribute="code">Code</th>
                    <th data-attribute="route.code">Route</th>
                    <th data-attribute="pretty_class">Class</th>
                    <th data-attribute="driver.code">Driver</th>
                    <th data-attribute="car.code">Car Code</th>
                    <th data-attribute="route.departure_station">Departure</th>
                    <th data-attribute="route.destination_station">Destination</th>
                    <th data-attribute="departure_time">Departure Time</th>
                    <th data-attribute="arrival_time">Arrival Time</th>
                    <th data-attribute="pretty_state">Status</th>
                    <th data-attribute="action" class="ac">Action</th>
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
                        {{ $trip->pretty_class }}</span>
                    </td>
                    <td>
                        {{ is_null($trip->driver) ? '' : $trip->driver->code }}
                    </td>
                    <td>
                        {{ is_null($trip->car) ? '' : $trip->car->code }}
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
                        {{ $trip->pretty_state }}
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
