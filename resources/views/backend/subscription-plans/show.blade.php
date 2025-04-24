{{-- Extends layout --}}
@extends('backend.partials.master')

@section('title')
    {{ $info->page_title }}
@endsection

{{-- Content --}}
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
                                            <th>Banner : <img src="{{ asset($data->banner ?? avatarUrl()) }}" style="height: 50px; width:50px"
                                                    alt=""> </th>
                                        </tr>
                                        <tr>
                                            <th>Title : {{ $data->title }}</th>
                                        </tr>
                                        <tr>
                                            <th>Slug : {{ $data->slug }}</th>
                                        </tr>

                                        <tr>
                                            <th>Price : {{ $data->price }} Tk</th>
                                        </tr>
                                        <tr>
                                            <th>Billing Cycle : {{ $data->billing_cycle->label() }}</th>
                                        </tr>
                                        <tr>
                                            <th>Created At : {{ customDateFormat($data->created_at) }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('css')
    @parent
@endsection

@section('js')
    @parent
@endsection
