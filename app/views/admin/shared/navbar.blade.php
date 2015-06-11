<header >
	<nav class="navbar navbar-fixed-top social-navbar top" role="navigation">

	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
	    <a class="navbar-brand" href="#">
	    	<img src="{{asset('assets/img/sample/logo-app.jpg')}}" alt="">
	    	<span>Paradep Travel Management System</span>
	    </a>
	  </div>

		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right nav-indicators">
				<li class="dropdown">
					<a href="dashboard.html#" class="dropdown-toggle" data-toggle="dropdown">
						<img id='current-user-avatar' src="{{ Helpers::avatar() }}" width="30px" alt="" class="avatar img-circle">
						<span>{{ Confide::user()->username }}</span>
						<i class="icon-caret-down"></i>
					</a>
					<ul class="dropdown-menu reveal" style="width:200px">
						<li>
							{{ Helpers::link_to('admin.profiles.edit', '<i class="icon icon-user"></i> Edit Profile', ['profiles' => Confide::user()->id],['class' => 'new-modal-form', 'data-target' => 'modal-edit-profile']) }}
						</li>
						<li>
							{{ Helpers::link_to('admin.profiles.new_password', '<i class="icon icon-lock"></i> Edit Password', ['profiles' => Confide::user()->id],['class' => 'new-modal-form', 'data-target' => 'modal-edit-password']) }}
						</li>
						<li><a href="pages/faq.html"><i class="icon-info-sign"></i> Help</a></li>
						<li class="divider"></li>
						<li><a href="{{ route('admin.sessions.destroy') }}"><i class="icon-off"></i> Log Out</a></li>
					</ul>
				</li>

			</ul>
		</div>
	</nav>
</header>
