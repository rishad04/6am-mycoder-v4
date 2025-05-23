@extends('frontend.partials.master')

@section('container')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        @if (auth()->user() != '')
            <h2>Welcome, {{ auth()->user()->name }} !</h2>
        @else
            {{-- <h2>Welcome To Landing Page</h2> --}}
        @endif
    </section>
    <!-- pricing Section -->
    <section id="pricing" class="pricing section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Task 1: Subscription Management</h2>
            <p>Subscription Plans<br></p>
        </div><!-- End Section Title -->

        <div class="container ">

            <div class="row gy-4 plan-cart">

                @foreach ($plans_frontend as $plan)
                    <div class="col-xl-4 col-lg-6 " data-aos="fade-up" data-aos-delay="100">
                        <div class="pricing-item  featured">
                            <h3>{{ $plan->title }}</h3>
                            <h4><sup>Tk</sup>{{ $plan->price }}<span> / {{ $plan->billing_cycle }}</span></h4>
                            <ul>
                                <li>{{ $plan->title }} Plan</li>
                                <li>Billing Cycle: {{ $plan->billing_cycle->label() }}</li>
                                {{-- <li class="na">Massa ultricies mi</li> --}}
                            </ul>
                            <div class="btn-wrap">
                                @auth
                                    <!-- If the user is authenticated, show the subscribe button -->
                                    @php
                                        $subscription = auth()->user()->activeSubscription();
                                    @endphp

                                    @if ($subscription != null && $subscription->subscriptionPlan->id == $plan->id)
                                        <a href="javascript:void(0);" class="btn-buy-green subscriptionView " id="subscribeButton2"
                                            data-plan-id="{{ $plan->id }}" data-plan-user-id="{{ $subscription->id }}">
                                            {{ $subscription->subscriptionPlan->id == $plan->id ? 'View Subscription' : 'Subscribe Now' }}
                                        </a>

                                        <a href="javascript:void(0);" class="btn-buy-cancel cancelSubscriptionBtn"
                                            data-subscription-id="{{ $subscription->id }}">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="btn-buy subscribeButton" id="subscribeButton"
                                            data-plan-id="{{ $plan->id }}">
                                            Subscribe Now
                                        </a>
                                    @endif

                                @endauth

                                @guest
                                    <!-- If the user is not authenticated, redirect to the login page -->
                                    <a href="{{ route('frontend.login') }}" class="btn-buy">Login To Subscribe</a>
                                @endguest
                            </div>
                        </div>
                    </div><!-- End Pricing Item -->
                @endforeach

            </div>

        </div>

    </section><!-- /About Section -->
    <!-- Pricing Section -->

    <!-- Subscription view modal sModal Structure -->
    <div id="subscriptionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscriptionModalLabel">Subscription Details</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <!-- Subscription details will be populated here -->
                    <div id="subscriptionDetails">
                        <!-- Dynamic content will go here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('frontend_scripts')
    <script>
        $(document).ready(function() {
            // When the Subscribe Now button is clicked
            $('.subscribeButton').click(function(e) {
                console.log('clicked');
                e.preventDefault(); // Prevent default link behavior

                // Get the plan ID from the data attribute
                const planId = $(this).data('plan-id');

                // Send the AJAX POST request
                $.ajax({
                    url: '{{ route('subscribe') }}', // The route to the subscribe method
                    method: 'POST',
                    data: {
                        plan_id: planId, // Send the plan ID to the server
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {

                        // console.log(response);
                        // Handle the success response
                        if (response.result === true) {
                            SwalFlashMiddlelert('Subscribed', 'Subscribed successfully!', 'Thanks for subscribing');
                            // console.log(location.href);
                            location.reload();
                        } else {
                            SwalFlashMiddlelert('Failed', response.message, 'Failed, Please Try Again', 'error');
                        }
                    },
                    error: function(xhr, status, error) {

                        console.log('xhr:', xhr);
                        console.log('status:', status);
                        console.log('error:', error);
                        // Handle the error response
                        if (xhr.status === 409) {
                            SwalFlashMiddlelert('Warning', 'Already Have This Subscription!',
                                'Please Try Another One', 'warning');
                        } else if (xhr.status === 403) {
                            SwalFlashMiddlelert('Not Allowed', 'Downgrade not allowed!',
                                'Please choose a higher level plan', 'warning');
                        } else {
                            SwalFlashMiddlelert('Failed', 'An error occurred.', 'Please try again later.', 'error');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.modal-close').on('click', function() {
                $('#subscriptionModal').modal('hide');
            });

            // When "View Subscription" button is clicked
            $('.subscriptionView').on('click', function() {
                var planId = $(this).data('plan-user-id'); // Get the plan ID from the button

                console.log(planId);
                // Make an AJAX request to fetch the subscription data
                $.ajax({
                    url: '/subscription/view/' + planId,
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                    },
                    success: function(response) {
                        // Check if the response is successful

                        console.log('sub-view-', response);
                        if (response.result && response.status_code == 200) {
                            var subscriptionData = response.data;

                            var modalContent = `
                                <p><strong>User:</strong> ${subscriptionData.user?.name || 'N/A'}</p>
                                <p><strong>Plan:</strong> ${subscriptionData.subscription_plan?.title || 'N/A'}</p>
                                <p><strong>Status:</strong> ${subscriptionData.payment_status || 'N/A'}</p>
                                <p><strong>Start Date:</strong> ${subscriptionData.start_date || 'N/A'}</p>
                                <p><strong>End Date:</strong> ${subscriptionData.end_date || 'N/A'}</p>
                            `;


                            $('#subscriptionDetails').html(modalContent);
                            $('#subscriptionModal').modal('show');
                        } else {
                            alert('Failed to load subscription details. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 404) {
                            alert('Subscription user not found.');
                        } else {
                            alert('An error occurred. Please try again later.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.cancelSubscriptionBtn', function() {
            const subscriptionId = $(this).data('subscription-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel your subscription?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('subscription.cancel') }}", // Route name
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            subscription_id: subscriptionId
                        },
                        success: function(response) {
                            Swal.fire('Cancelled!', response.message, 'success');
                            // $('.plan-cart').load(location.href + ' .plan-cart'); // Refresh only the plan-cart
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    {{-- task: 2 --}}

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`; // Add semicolon at the beginning to handle edge cases
            const parts = value.split(`; ${name}=`); // Split the cookie string by the name
            if (parts.length === 2) return parts.pop().split(';').shift(); // Return the cookie value if found
            return null; // Return null if cookie is not found
        }
        let login_frontend_cookie = getCookie('frontend_user_session_cookie');

        if (login_frontend_cookie != null) {
            console.log('cookie for frontend is Set');

            function checkForNotification() {
                fetch('/get-latest-notification')
                    .then(res => res.json())
                    .then(data => {
                        // console.log(data);

                        if (data.message != null) {

                            const blinker = document.getElementById('notification-blinker');
                            blinker.classList.remove('d-none');
                            SwalFlashNotificationAlert(true, '🔔 ' + data.message, null, null);
                        }

                    })
                    .catch(error => {
                        console.error('Error fetching latest notification:', error);
                    });
            }
        } else {
            console.log('cookie for frontend is null');
        }
        setInterval(checkForNotification, 3000);
    </script>
@endpush
