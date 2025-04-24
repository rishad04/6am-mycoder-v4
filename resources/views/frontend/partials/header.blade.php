<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">6amTask By Rishad: Frontend</h1>

        </a>

        {{-- <button onclick="showNotification('Welcome! This is a test notification.')">Show Notification</button> --}}

        <nav id="navmenu" class="navmenu" style="margin-right:10px">
            {{-- @dd(request()->url()) --}}
            <ul>

                <li>
                    <a href="{{ route('frontend.landing.index') }}" class="{{ request()->is('home*') ? 'active' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('frontend.product-showcase.index') }}"
                        class="{{ request()->is('product-showcase') ? 'active' : '' }}">Products</a>
                </li>

                @php
                    try {
                        // Using Redis::connection() to ping the Redis server
                        $isRedisRunning = \Illuminate\Support\Facades\Redis::ping() === 'PONG';
                        $isRedisRunning = true;
                    } catch (\Exception $e) {
                        // In case Redis is not available
                        $isRedisRunning = false;
                    }
                @endphp

                @if ($isRedisRunning)
                    <li>
                        <a href="{{ route('frontend.product-showcase-cached.index') }}"
                            class="{{ request()->is('product-showcase-cached*') ? 'active' : '' }}">
                            Products(Cached)
                        </a>
                    </li>
                @endif

                @if (auth()->user() != '')
                    <li>
                        <a href="{{ route('frontend.my-tasks.index') }}" class="{{ request()->is('my-task*') ? 'active' : '' }}">My
                            Tasks</a>
                    </li>

                    <li class="dropdown" id="notification-dropdown">
                        <a href="javascript:void(0);" onclick="loadNotifications()">
                            <span>
                                <span id="notification-blinker" class="blink d-none"></span> Notifications
                            </span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul id="notification-list">
                            <!-- Notifications will be loaded here via JS -->
                        </ul>
                    </li>
                @endif

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @if (auth()->user() != '')
            {{-- <h6 class="sitename">Logged In As {{ auth()->user()->name }} | </h6>

            <h6 class="sitename"> Cash Amount: {{ auth()->user()->have_cash_amount }} Tk</h6> --}}

            {{-- <a class="btn-getstarted" href="{{ route('frontend.logout') }}"> Logout</a> --}}

            <form action="{{ route('frontend.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <a class="btn btn-success mr-5" href="{{ route('frontend.login') }}">Login</a>
            <a class="btn btn-danger" href="{{ route('frontend.register') }}">Register</a>
        @endif

    </div>
</header>

@push('frontend_scripts')
    <script>
        function loadNotifications() {
            fetch("/notifications/fetch")
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById("notification-list");
                    list.innerHTML = ''; // Clear old items

                    if (data.notifications.length > 0) {
                        data.notifications.forEach(notification => {
                            const li = document.createElement("li");
                            li.innerHTML = `<a href="#">${notification.message}</a>`;
                            list.appendChild(li);
                        });

                        // Hide blinker once viewed
                        document.getElementById('notification-blinker').classList.add('d-none');
                    } else {
                        const li = document.createElement("li");
                        li.innerHTML = `<a href="#">No new notifications</a>`;
                        list.appendChild(li);
                    }
                })
                .catch(error => {
                    console.error("Error loading notifications:", error);
                });
        }
    </script>
@endpush
