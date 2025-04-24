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
                            </div>

                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered display no-wrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Serial</th>
                                            <th>Message</th>
                                            <th>Is Broadcasted</th>
                                            <th>Creating Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $serial = 1;
                                        @endphp

                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $serial }}</td>

                                                <td>{{ $row->message }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-md">
                                                        <input type="checkbox" name="is_broadcasted" value="{{ $row->id }}"
                                                            onclick="toggleSwitchStatus(this,'notifications');" class="form-check-input"
                                                            @if ($row->is_broadcasted == 1) checked @endif>
                                                    </div>

                                                </td>

                                                <td>{{ customDateFormat($row->created_at) }}
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
