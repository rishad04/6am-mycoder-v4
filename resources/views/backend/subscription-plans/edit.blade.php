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
                            <form action="{{ route($info->form_route, $data->id) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-body">
                                    <div class="row">

                                        <!-- Banner Upload -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="banner">Banner</label>
                                                <div class="admin__thumb-upload">
                                                    <div class="admin__thumb-edit">
                                                        <input type="file" class="@error('banner') is-invalid @enderror" id="banner"
                                                            name="banner" onchange="imagePreview(this, 'image_preview_banner');"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label for="banner"></label>
                                                    </div>
                                                    <div class="admin__thumb-preview">
                                                        <div id="image_preview_banner" class="admin__thumb-profilepreview"
                                                            style="background-image: url({{ $data->banner ? asset($data->banner) : asset(avatarUrl()) }});">
                                                        </div>
                                                    </div>
                                                    @error('banner')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Title -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Title&#42;</label>
                                                <input type="text" value="{{ old('title', $data->title) }}"
                                                    class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                                    placeholder="Enter Title" />
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="price">Price&#42;</label>
                                                <input type="number" value="{{ old('price', $data->price) }}"
                                                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                                    placeholder="Enter Price" />
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Billing Cycle -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="billing_cycle">Billing Cycle&#42;</label>
                                                <select class="form-select search-select @error('billing_cycle') is-invalid @enderror"
                                                    id="billing_cycle" name="billing_cycle" data-live-search="true">
                                                    <option value="">--Choose--</option>
                                                    @foreach (App\Enums\BillingCycleEnum::cases() as $cycle)
                                                        <option value="{{ $cycle->value }}" @if (old('billing_cycle', $data->billing_cycle->value) == $cycle->value) selected @endif>
                                                            {{ $cycle->label() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('billing_cycle')
                                                    <div class="invalid">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5"
                                                    placeholder="Enter Description">{{ old('description', $data->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Is Popular -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input @error('is_popular') is-invalid @enderror" type="checkbox"
                                                        name="is_popular" id="is_popular" @if (old('is_popular', $data->is_popular) == '1') checked @endif />
                                                    <label class="form-check-label" for="is_popular">Is Popular</label>
                                                    @error('is_popular')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Submit and Reset Buttons -->
                                <div class="form-actions">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-info mt-2">{{ __('Update') }}</button>
                                        <button type="reset" class="btn btn-dark mt-2">{{ __('Reset') }}</button>
                                    </div>
                                </div>
                            </form>

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
