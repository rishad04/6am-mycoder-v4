<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i
                            data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Task 1</span></li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                            data-feather="grid" class="feather-icon"></i><span class="hide-menu">Subscription Manage </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="{{ route('admin.subscription-plans.index') }}" class="sidebar-link"><span
                                    class="hide-menu"> Subscription Plans
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="{{ route('admin.subscription-users.index') }}" class="sidebar-link"><span
                                    class="hide-menu"> User
                                    Subscriptions
                                </span></a>
                        </li>
                    </ul>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Task 2</span></li>

                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.notification.index') }}"
                        aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Notifications</span></a>
                </li>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Task 3</span></li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                            data-feather="grid" class="feather-icon"></i><span class="hide-menu">Product Manage</span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="{{ route('admin.product-categories.index') }}" class="sidebar-link"><span
                                    class="hide-menu"> Category
                                </span></a>
                        </li>
                        <li class="sidebar-item"><a href="{{ route('admin.products.index') }}" class="sidebar-link"><span class="hide-menu">
                                    Products
                                </span></a>
                        </li>
                    </ul>

                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Task 4</span></li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
                            data-feather="grid" class="feather-icon"></i><span class="hide-menu">Task Manage</span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item"><a href="{{ route('admin.tasks.index') }}" class="sidebar-link"><span class="hide-menu">
                                    User Tasks
                                </span></a>
                        </li>
                    </ul>

                <li class="list-divider"></li>

                {{-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="authentication-login1.html" aria-expanded="false"><i
                            data-feather="log-out" class="feather-icon"></i><span class="hide-menu">Logout</span></a></li> --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
