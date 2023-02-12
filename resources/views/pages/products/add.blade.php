@extends('layouts.app')

@section('title', 'Add Product URL')

@section('content')

    <h1 class="h3 mb-3">Add New Product URL</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <script>
                            window.notyf.open({
                                'type': 'success',
                                'message': '{{ session('success') }}',
                                'duration': 12000,
                                'ripple': true,
                                'dismissible': true
                            });
                        </script>
                    @endif

                    @if(session('error'))
                            <script>
                                window.notyf.open({
                                    'type': 'danger',
                                    'message': '{{ session('danger') }}',
                                    'duration': 12000,
                                    'ripple': true,
                                    'dismissible': true
                                });
                            </script>
                    @endif


                    <form method="post" action="{{ route('products.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="product">Product</label>
                            <input
                                class="form-control form-control-lg mb-3"
                                type="text"
                                name="product"
                                placeholder=""/>
                        </div>

                        <div class="form-group">

                            <button type="submit" class="btn btn-lg btn-primary">Add New URL</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
