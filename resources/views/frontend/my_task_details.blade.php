@extends('frontend.partials.master')

@section('container')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Task View(Details)</h1>
            <div class="header d-flex align-items-center sticky-top">
                <div class="container-fluid container-xl position-relative d-flex align-items-center">
                    <!-- <a class="btn-getstarted" href="about.html"> + Create A Task</a> -->
                </div>
            </div>
            <nav class="breadcrumbs">
                <ol>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Features Section -->
    <section id="features" class="features section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Task Details</h2>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">

                <div class="col-lg-9 mt-4 mt-lg-0">

                    <div class="tab-content">
                        <div class="tab-pane active show" id="features-tab-1">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">

                                    <h3>Title: {{ $task->title }} </h3>
                                    <p class="fst-italic">Status: {{ $task->is_completed == 1 ? 'Completed' : 'Pending' }}</p>
                                    <p class="fst-italic">Description: {{ $task->description }}</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="{{ asset('frontend/assets/img/tabs/tab-1.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

    </section><!-- /Features Section -->

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="taskForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">Create New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('frontend_scripts')
    <script>
        $(document).ready(function() {
            // Show modal on button click
            $('#create-task-btn').click(function() {
                $('#taskModal').modal('show');
            });

            // Handle form submit via AJAX
            $('#taskForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('frontend.my-tasks.store') }}', // Define this route in your web.php
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        SwalFlashMiddlelert('Created', 'Created successfully!', 'Thanks for creating task');
                        $('#taskModal').modal('hide');
                        $('#taskForm')[0].reset();
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>
@endpush
