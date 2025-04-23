@extends('frontend.partials.master')

@section('container')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">My Tasks</h1>
            <div class="header d-flex align-items-center sticky-top">
                <div class="container-fluid container-xl position-relative d-flex align-items-center">
                    <a id="create-task-btn" class="btn-getstarted" href="javascript:void(0)">+ Create A Task</a>
                </div>
            </div>
            <nav class="breadcrumbs">
                <ol>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Services Section -->
    <section id="services" class="services section">

        <div class="container">

            <div class="row gy-4">

                @foreach ($tasks as $task)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item d-flex position-relative h-100">
                            {{-- <i class="bi bi-calendar4-week icon flex-shrink-0"></i> --}}
                            <div>
                                @if ($task->is_completed == 1)
                                    <button class="btn btn-success mr-5 float-right"
                                        onclick="showNotification('You have a new message!')">Completed
                                    </button>
                                @else
                                    <button class="btn btn-danger mr-5 float-right"
                                        onclick="showNotification('You have a new message!')">Pending
                                    </button>
                                @endif
                                <h4 class="title"><a href="{{ route('frontend.my-tasks.details', $task->id) }}"
                                        class="stretched-link">{{ $task->title }}</a></h4>
                                <p class="description">{{ $task->description }}</p>
                                <p class="description">Created At {{ $task->created_at }}</p>

                            </div>
                        </div>
                    </div><!-- End Service Item -->
                @endforeach

                {{ $tasks->links('pagination::bootstrap-4') }}
            </div>

        </div>

    </section><!-- /Services Section -->

    </div>

    </section><!-- /Services Section -->

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
