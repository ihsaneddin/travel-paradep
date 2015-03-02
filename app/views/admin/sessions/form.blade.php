{{ Form::model(@user, [
                'route' => 'admin.sessions.store',
                'method' => 'post',
                'role' => 'form',
                'class' => 'form'
                ]); }}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Login</h3>
                        </div>
                        <div class="panel-body">

                            @if(Session::get('error'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if(Session::get('notice'))
                                <div class="alert alert-notice alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session::get('notice') }}
                                </div>
                            @endif

                                <div class="form-group">
                                    {{ Form::text(
                                        "username",
                                        Input::old("email"),
                                        array(
                                            "placeholder" => "Username",
                                            "class" => "form-control"
                                        ))
                                    }}
                                </div>

                                <div class="form-group">
                                    {{ Form::password(
                                        "password",
                                        array(
                                            "placeholder" => "Password",
                                            "class" => "form-control"
                                        ))
                                    }}
                                </div>

                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('remember') }}
                                        Remember Me
                                    </label>
                                </div>
                        </div>
                        <div class="panel-footer">
                            {{ Form::submit("Login", array("class" => 'btn btn-primary')) }}
                            
                        </div>
                    </div>
{{ Form::close() }}