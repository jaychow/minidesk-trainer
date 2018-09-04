        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Admin</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('manage-admin') }}" aria-expanded="false"><i class="icon-People-onCloud"></i><span class="hide-menu">Manage Admin </span></a>
                        </li>
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Import Data</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('data-import') }}" aria-expanded="false"><i class="icon-File-Excel"></i><span class="hide-menu">Import Data </span></a>
                        </li>
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Trend</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('trend') }}" aria-expanded="false"><i class="icon-Bar-Chart5"></i><span class="hide-menu">Trend </span></a>
                        </li>
                        <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Setting</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('setting') }}" aria-expanded="false"><i class="icon-Gears"></i><span class="hide-menu">Setting </span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
