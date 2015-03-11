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
                <dl class="dl-horizontal">
                    <dt>Nama</dt>
                    <dd>Bayu Hendra Winata</dd>
                    <dt>Alamat</dt>
                    <dd>Jalan Surapati Core Blok L-26 Bandung</dd>
                    <dt>Pekerjaan</dt>
                    <dd>Wiraswasta</dd>
                    <dt>Example Empty Row</dt>
                    <dd></dd>
                    <dt>Example Very Looooong Label</dt>
                    <dd>Hay there</dd>
                    <dt>Bio</dt>
                    <dd>
                        Maecenas sed diam eget risus varius blandit sit amet non magna. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean lacinia bibendum nulla sed consectetur. Maecenas faucibus mollis interdum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Donec ullamcorper nulla non metus auctor fringilla.
                    </dd>
                </dl>
          </div>
        </div>
    </div>
</div>
    
@stop