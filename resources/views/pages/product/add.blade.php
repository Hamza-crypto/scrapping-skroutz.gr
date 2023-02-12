@extends('layouts.app')

@section('title', 'Add Product')

@section('scripts')
    <script>
    </script>
@endsection
@section('content')

    <h1 class="h3 mb-3">Add New Product </h1>

    <div class="row">

        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif
        @if(session('warning'))
            <x-alert type="warning">{{ session('warning') }}</x-alert>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('products.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="number">Skroutz link</label>
                                    <input
                                        class="form-control form-control-lg @error('link') is-invalid @enderror"
                                        type="url"
                                        name="link"
                                        placeholder="Enter Skroutz link to scrape"
                                        value="{{ old('link' )}}"
                                    />

                                    @error('link')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">
                                    <label for="month">Product ID</label>
                                    <input
                                        class="form-control form-control-lg @error('product_id') is-invalid @enderror"
                                        type="number"
                                        name="product_id"
                                        placeholder="Enter product ID in E-shop"
                                        value="{{ old('product_id') }}"
                                    />
                                    @error('product_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row" style="">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="year">Price Cap</label>
                                    <input
                                        class="form-control form-control-lg @error('soft_cap') is-invalid @enderror"
                                        type="text"
                                        name="soft_cap"
                                        placeholder="Enter price cap"
                                        value="{{ old('soft_cap') }}"
                                    />
                                    @error('soft_cap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit" id="add" class="btn btn-lg btn-primary">Add New
                                Product
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
