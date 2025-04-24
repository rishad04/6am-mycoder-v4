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
                            <div class="float-right">
                                {{-- @can('product-create')
                                    <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                                        <i class="flaticon2-add"></i>
                                        + {{ $info->first_button_title }}
                                    </a>
                                @endcan --}}

                            </div>

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>

                                            <th>Title</th>
                                            <th>Is Active</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $serial = 1;
                                        @endphp

                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $serial }}</td>

                                                <td>{{ $row->title }}
                                                </td>

                                                <td>
                                                    <div class="form-check form-switch form-switch-md">
                                                        <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                            onclick="toggleSwitchStatus(this,'subscription_plans');" class="form-check-input"
                                                            @if ($row->is_active == 1) checked @endif>
                                                    </div>

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
    @include('backend.components.modals.delete')
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
