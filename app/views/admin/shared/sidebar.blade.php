<aside class="sidebar">
    <div class="sidebar-content">
        <div class="scrollable">
            <div href="#" class="navigation-sidebar">
                <a data-container="body" data-placement="right" data-original-title=""
                    data-sidebar-full="Click To Minimize"
                    data-sidebar-mini="Click To Auto Hide"
                    data-sidebar-auto="Click To Permanently Expand"
                >
                    <i class="switch-sidebar-icon icon-none"></i>
                </a>
            </div>

            <div class="search-sidebar hide">
                <i class="icon-search icon-2"></i>
                <form class="search-sidebar-form">
                <input type="text" class="search-query input-block-level" placeholder="Search">
                </form>
            </div>

            <section class="menu">
                <div class="accordion" id="accordion-sidebar">

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            
                            {{Helpers::link_to('admin.dashboards.index', '<i class="icon-dashboard icon-1"><span>Dahsboard</span><span class="arrow"></span></i>',[],['class'=> 'accordion-toggle', 'data-parent' => '#accordion-sidebar'])}}
                            
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-sidebar" href="#collapse-master">
                                <i class="icon-tasks icon-2">
                                    <span>Master</span><span class="arrow"></span>
                                </i>
                            </a>
                        </div>
                        <ul id="collapse-master" class="accordion-body nav nav-list collapse sub-menu">
                            <li>
                                {{Helpers::link_to('admin.master.users.index', '<i class="icon-user icon"></i> <span>Users</span>', [], [])}}
                            </li>
                            <li><a href="{{url('demo/dashboard-control-panel')}}"><i class="icon-circle-blank icon"></i> <span>Control Panel</span></a></li>
                            <li><a href="{{url('demo/dashboard-notification')}}"><i class="icon-circle-blank icon"></i> <span>Notification</span></a></li>
                        </ul>
                    </div>
            </section>
        </div>

        <div class="chat-users hide" style="height:0">
            <div class="no-user">User not found</div>
            <ul class="user-list">
                <li>
                    <a data-firstname="Cesar" data-lastname="Mendoza" data-status="online" data-userid="1" href="#">
                        <i class="icon-user icon-2"></i>
                        <span>Cesar Mendoza</span>
                        <i class="icon-circle user-status online"></i>
                    </a>
                </li>
            </ul>

            <form class="user-filter">
                <div class="input-prepend open">
                    <div class="btn-group dropup">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-cog"></i>
                        </button>
                        <ul class="dropdown-menu pull-left">
                            <li><a href="#">Chat Sounds</a></li>
                            <li><a href="#">Advanced Settings...</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Turn Off Chat</a></li>
                        </ul>
                    </div>
                    <input type="text" class="input-filter" placeholder="Search user...">
                </div>
            </form>
        </div>
    </div>
</aside>