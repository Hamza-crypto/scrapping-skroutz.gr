@extends('layouts.app')

@section('title', 'Products')

@section('scripts')
    <script>
        $(document).ready(function () {

            $("input[id=\"daterange\"]").daterangepicker({

                autoUpdateInput: false,
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            }).on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
//p = pagination
// f = find
            var table = $('#products-table').DataTable({
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': "{{  route('products.ajax')  }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (data) {

                        data.store = $('#store').val();
                        data.status = $('#status').val();

                        var queryString = ''; //'&status=' + data.status + '&store=' + data.store;
                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + queryString;
                        window.history.pushState({path: newurl}, '', newurl);

                    },
                    dataSrc: function (data) {
                        return data.data;
                    }
                },
                'columns': [
                    {"data": "eshop_id"},
                    {"data": "price"},
                    {"data": "soft_cap"},
                    {"data": "ignored"},
                    {"data": "url"},
                    {"data": "actions", "className": 'table-action'}
                ],
                "initComplete": function () {
                    var api = this.api();

                }

            });

            $('.apply-dt-filters').on('click', function () {
                table.ajax.reload();
            });

            $('.clear-dt-filters').on('click', function () {
                $('#status').val('0').trigger('change');
                $('#store').val('1').trigger('change');

                table.search("");
                table.ajax.reload();
            });



            $('#select_all_btn').parent().hide();

            //hide element with jquery
            $('#products-table_filter').hide();

            //send ajax request to update soft_cap value when text field is changed
            $(document).on('change', '.soft_cap', function () {
                var id = $(this).attr('data-id');
                var soft_cap = $(this).val();
                $.ajax({
                    url: "/softcap/" + id,
                    method: "PUT",
                    data: {
                        id: id,
                        soft_cap_new_val: soft_cap,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                                window.notyf.open({
                                'type': 'success',
                                'message': data.message,
                                'duration': 2000,
                                'ripple': true,
                                'dismissible': true
                            });


                        } else {
                            window.notyf.open({
                                'type': 'error',
                                'message': 'Something went wrong',
                                'duration': 2000,
                                'ripple': true,
                                'dismissible': true
                            });
                        }
                    }
                });
            });

            $(document).on('change', '.ignore_status', function () {

                let ignore = 0;
                if ($(this)[0].checked) {
                    ignore = 1;
                }
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "/status/" + id,
                    method: "PUT",
                    data: {
                        id: id,
                        ignore_status: ignore,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                                window.notyf.open({
                                'type': 'success',
                                'message': data.message,
                                'duration': 2000,
                                'ripple': true,
                                'dismissible': true
                            });


                        } else {
                            window.notyf.open({
                                'type': 'error',
                                'message': 'Something went wrong',
                                'duration': 2000,
                                'ripple': true,
                                'dismissible': true
                            });
                        }
                    }
                });
            });

        });
    </script>
@endsection

@section('content')
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @elseif(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @elseif(session('warning'))
        <x-alert type="warning">{{ session('warning') }}</x-alert>
    @endif


    <h1 class="h3 mb-3">All Products</h1>

{{--    <div class="row">--}}
{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <form>--}}
{{--                        <input type="hidden" class="d-none" name="filter" value="true" hidden>--}}
{{--                        <div class="row">--}}

{{--                                <div class="col-sm">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="form-label" for="store">{{ 'Store' }}</label>--}}
{{--                                        <select name="store" id="store"--}}
{{--                                                class="form-control form-select custom-select select2"--}}
{{--                                                data-toggle="select2">--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-sm">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="form-label" for="status"> Status </label>--}}
{{--                                        <select name="status" id="status"--}}
{{--                                                class="form-control form-select custom-select select2"--}}
{{--                                                data-toggle="select2">--}}
{{--                                            <option value="0" selected> Whitelisted </option>--}}
{{--                                            <option value="1"> Blacklisted </option>--}}

{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-sm mt-4">--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-sm btn-primary apply-dt-filters mt-2">{{ __('Apply') }}</button>--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-sm btn-secondary clear-dt-filters mt-2">{{ __('Clear') }}</button>--}}

{{--                                <button type="button" class="btn btn-sm btn-secondary mt-2"--}}
{{--                                        onclick="get_query_params2()"--}}
{{--                                >{{ 'Export ' }}</button>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="products-table" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Price</th>
                            <th>Soft Cap</th>
                            <th>Mark Ignore</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


