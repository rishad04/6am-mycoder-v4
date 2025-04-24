@extends('backend.partials.master')

@section('title')
    {{ $info->page_title }}
@endsection
@section('container')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $info->title }}</h4>
                            <div class="float-right">
                                @can('subscription-plan-create')
                                    <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                                        <i class="flaticon2-add"></i>
                                        + {{ $info->first_button_title }}
                                    </a>
                                @endcan
                            </div>

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Banner</th>
                                            <th>Title</th>
                                            <th>Price</th>
                                            <th>Billing Cycle</th>
                                            <th>Is Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $serial = 1;
                                        @endphp

                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $serial }}</td>
                                                <td>
                                                    <div class="mc-item d-flex gap-2">
                                                        <div class="mc-thumb">
                                                            <img src="@if ($row->banner != '') {{ asset($row->banner) }} @else {{ asset(avatarUrl()) }} @endif"
                                                                alt="avatar">
                                                        </div>
                                                    </div>

                                                </td>

                                                <td>{{ $row->title }}
                                                </td>
                                                <td>{{ $row->price }}
                                                </td>
                                                <td>{{ $row->billing_cycle }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-md">
                                                        <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                            onclick="toggleSwitchStatus(this,'subscription_plans');" class="form-check-input"
                                                            @if ($row->is_active == 1) checked @endif>
                                                    </div>

                                                </td>
                                                <td>

                                                    <a class="trk-action__item trk-action__item--success"
                                                        href="{{ route('admin.subscription-plans.show', $row->id) }}">
                                                        <i class="lni lni-eye"></i>
                                                    </a>

                                                    <a class="" href="{{ route('admin.subscription-plans.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        onclick="ajaxDelete(`{{ route('admin.subscription-plans.destroy', $row->id) }}`, 'Subscription Plan', this)">
                                                        <i class="lni lni-trash-can text-danger"></i>
                                                    </a>
                                                </td>
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
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
