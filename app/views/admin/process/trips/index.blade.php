@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs()}}
@stop

@section('content')
    <div class="page box" id="pageCrud">
        <h2 class="page-title">Trips Management</h2>
        <div class="container">
            <div class="row">

                <form action="#" class="form mb clearfix" role="form">
                    <div class="form-group">
                        <div class="col-sm-6 pad-zero">
                            <input type="text" class="form-control" placeholder="Search something">
                        </div>
                        <div class="col-sm-2">
                            <a href="" class="btn btn-default btn-block">Search</a>
                        </div>
                        <div class="col-sm-2 pad-zero">
                            <a href="#" class="btn btn-link" id="btnToggleAdvanceSearch">Advance Search</a>
                        </div>
                    </div>
                </form>

                <form action="" class="form well form-horizontal clearfix hide" role="form" id="formAdvanceSearch">
                    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail1" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="inputEmail1" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="inputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-sm-3 control-label">Location</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm">
                                <option>Jakarta</option>
                                <option>Bandung</option>
                                <option>Surabaya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-sm-3 control-label">Registered Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm input-date" placeholder="From">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm input-date" placeholder="To">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-push-3">
                            <input type="submit" class="btn btn-block" value="Search" />
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">

                    </div>

                </form>

                <div class="clearfix"></div>

                <div class="panel panel-default" id="panelCrud">
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">
                            <span class="pad-right">Trips List</span>
                        </h3>
                        <div class="panel-action pull-right">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>
                    <div class="box-control row box">
                        <div class="col-sm-6">

                            <a data-toggle="modal" href="#modalAdd" class="btn btn-primary"><i class="icon icon-plus"></i> New Trip</a>
                        </div>
                        <div class="btn-group col-sm-6">
                            <div class="pull-right btn-group">
                                <button type="button" class="btn"><i class="icon icon-chevron-left"></i></button>
                                <span class="btn">1/50</span>
                                <button type="button" class="btn"><i class="icon icon-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="boxCrud">
                        <div class="table-responsive">
                            <table class="table datatable table-striped table-condensed table-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Route</th>
                                        <th>Driver</th>
                                        <th>Car Code</th>
                                        <th>Departure</th>
                                        <th>Destination</th>
                                        <th>Departure Time</th>
                                        <th>Arrival Time</th>
                                        <th class="ac">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{ empty_table($trips->isEmpty(), 10) }}

                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-pagination ac">
                        <ul class="pagination">
                            <li><a href="#">&laquo;</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.shared.confirmation')

@stop