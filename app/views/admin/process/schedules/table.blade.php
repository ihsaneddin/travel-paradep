<div id="boxCrud">
    <div class="table-responsive">
        <table class="table datatable table-striped table-condensed table-middle" id="table-schedules-index">
            <thead>
                <tr>
                    <th data-attribute="hour">Hour</th>
                    <th data-attribute="route.name">Route</th>
                    <th data-attribute="weekend">Weekend</th>
                    <th data-attribute="action" data-action-edit="<a id='change-schedule-schedule_id' href='{{route('admin.process.schedules.edit',array('schedules' => 'schedule_id'))}}' class='btn btn-xs new-modal-form' data-table='table-schedules-index'><i class='icon icon-edit'></i></a>"  >Action</th>
                </tr>
            </thead>
            <tbody>

                {{ empty_table($schedules->isEmpty(), 4, 'No schedule is found') }}

                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->hour }}</td>
                        <td>{{ $schedule->route->name }}</td>
                        <td>{{ $schedule->weekend }}</td>
                        <td>
                            <div class="btn-group action">
                                <a href="{{ route('admin.process.schedules.edit',array('schedules' => $schedule->id)) }}" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-schedule-{{ $schedule->id }}" data-table="#table-schedules-index"><i class="icon icon-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="box-pagination ac">
    {{ $schedules->appends(Input::all())->links() }}
</div>
