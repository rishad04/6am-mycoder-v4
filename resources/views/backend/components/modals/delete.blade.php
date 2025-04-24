<!-- Modal -->
<div class="modal fade" id="subscriptionModal_{{ $row->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $row->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $row->id }}">Subscription Plan Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Title:</strong> {{ $row->title }}</li>
                    <li class="list-group-item"><strong>Slug:</strong> {{ $row->slug }}</li>
                    <li class="list-group-item"><strong>Price:</strong> {{ $row->price }}</li>
                    <li class="list-group-item"><strong>Is Popular:</strong> {{ $row->is_popular ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Billing Cycle:</strong> {{ $row->billing_cycle }}</li>
                    <li class="list-group-item"><strong>Description:</strong> {!! $row->description !!}</li>
                </ul>
            </div>

            <div class="modal-footer">
                <a href="{{ route('admin.subscription-plans.edit', $row->id) }}" class="btn btn-primary">
                    Edit
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
