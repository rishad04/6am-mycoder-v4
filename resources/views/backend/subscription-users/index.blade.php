@extends('backend.partials.master')

@section('title')
    {{ $page_title }}
@endsection
@section('container')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $info->title }}</h4>

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>User Info</th>
                                            <th>Plan Info</th>
                                            <th>Subscription Period</th>
                                            <th>Payment Info</th>
                                            <th>status</th>
                                            <th>Subscribed</th>
                                            <th>Cancelled By</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $serial = 1;
                                        @endphp

                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $serial }}
                                                </td>

                                                <td>
                                                    <div>
                                                        {{ $row->user?->name }}
                                                    </div>
                                                    <div>
                                                        <a href="#" class="link-color">
                                                            {{ $row->user?->email }}
                                                        </a>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div>
                                                        Title: {{ $row->subscriptionPlan?->title }}
                                                    </div>
                                                    <div>
                                                        <a href="#" class="link-color">
                                                            Cycle: {{ $row->subscriptionPlan?->billing_cycle }}
                                                        </a>
                                                    </div>
                                                </td>

                                                <td>

                                                    <div>Start Date: {{ customDateFormat($row->start_date) }}</div>
                                                    <div>End Date: {{ customDateFormat($row->end_date) }}</div>

                                                </td>

                                                <td>
                                                    <div>
                                                        paid: {{ $row->paid }} Tk
                                                    </div>
                                                    <div>
                                                        <a href="#" class="link-color">
                                                            Method: {{ $row->payment_method }}
                                                        </a>
                                                    </div>
                                                </td>

                                                <td>
                                                    @if ($row->user_unsubscribed_at != '')
                                                        {{ \App\Enums\StripeStatusEnum::CANCELLED->label() }}
                                                    @else
                                                        {{ $row->is_active ? \App\Enums\StripeStatusEnum::SUCCEEDED->label() : \App\Enums\StripeStatusEnum::FAILED->label() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-md">
                                                        <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                            onclick="toggleSwitchStatus(this,'subscription_users');" class="form-check-input"
                                                            @if ($row->is_active == 1) checked @endif>
                                                    </div>

                                                </td>

                                                <td>
                                                    {{ $row->user_unsubscribed_at != '' ? 'User at: ' . customDateFormat($row->user_unsubscribed_at) : '-' }}
                                                </td>

                                                {{-- <td>
                                                    <a class="trk-action__item trk-action__item--success"
                                                        href="{{ route('admin.subscription-users.show', $row->id) }}">
                                                        <i class="lni lni-eye"></i>
                                                    </a>
                                                    <a class="trk-action__item trk-action__item--warning"
                                                        href="{{ route('admin.subscription-users.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                    <a onclick="Delete(`{{ route('admin.subscription-users.destroy', $row->id) }}`)"
                                                        class="trk-action__item trk-action__item--danger" href="#">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>

                                                </td> --}}
                                            </tr>
                                            @php
                                                $serial++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $data->links('pagination::bootstrap-4') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- @include('backend.components.modals.delete') --}}
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
