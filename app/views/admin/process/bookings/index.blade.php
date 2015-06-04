@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs()}}
@stop

@section('content')


     <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title pull-left"> Bookings Management</h3>
            </div>
            <div class="panel-body">
                <div class="page box" id="pageCrud">
                    <div class="container">
                        <div class="row">

                            @include('admin.process.bookings.filter')

                            <div class="clearfix"></div>

                            <div class="panel panel-default" id="panelCrud">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">
                                        <span class="pad-right">Bookings List</span>
                                    </h3>
                                    <div class="panel-action pull-right">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-control row box">
                                    <div class="col-sm-6">
                                    </div>
                                    <div class="btn-group col-sm-6">
                                        <div id="simple-pagination" class="pull-right btn-group">
                                            <a href="" class="btn simple-paginate simple-prev"><i class="icon icon-chevron-left"></i></a>
                                            <span class="btn current-page">{{ $bookings->getCurrentPage() }}</span>
                                            <a href="" class="btn simple-paginate simple-next"><i class="icon icon-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="table-index">
                                    @include('admin.process.bookings.table', ['bookings' => $bookings, 'options' => $options])
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.shared.confirmation')

@stop