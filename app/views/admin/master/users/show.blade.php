@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($user)}}
@stop

@section('content')

<div class="box">
    <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">
              {{Helpers::tableTitle()}}
              <div class="pull-right panel-action">
                  <div class="btn-group">

                      {{Helpers::link_to('admin.master.users.edit', '<i class="icon icon-pencil"></i>', ['users' => $user->id],['class' => 'btn btn-default new-modal-form', 'data-target' => 'modal-edit-user-'.$user->id ])}}

                  </div>
              </div>
          </div>
          <div class="panel-body">
             @include('admin.master.users.detail', array('user' => $user))
          </div>
        </div>
    </div>
</div>

@stop