@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }} <small>Please upload .CSV file with column title.</small></div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div style="width:100%; float: right;">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div style="width:100%; float: right;">
                    <div class="alert alert-danger alert-dismissible">
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <div class="card-body">
                    <form id="excel-csv-import-form" method="POST" action="{{ route('product.import') }}"
                        accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="file" name="file" id="file_csv" placeholder="Choose file" required
                                        title="Please upload CSV ">
                                </div>
                                @error('file')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" id="submit">Import</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">

                <div class="card-body">

                    <div class="col-md-12">
                        <table id="product-table" class="table table-responsive">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>SKU</th>
                                <th>Description</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $('#product-table').DataTable();

    $('#file_csv').on('change', function () {
        if ($(this).val().toLowerCase().lastIndexOf(".csv") == -1) {
            alert ('Please upload CSV file.!');
            $(this).val('');
            return false;
        }
    })
</script>
@endsection