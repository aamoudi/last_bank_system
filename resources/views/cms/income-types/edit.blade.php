@extends('cms.parent')

@section('title','Edit Income Type')
@section('page-name','Edit Income Type')
@section('main-page','Income Types')
@section('sub-page','Edit Income Type')

@section('styles')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Income Type</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $incomeType->name }}" id="name"
                                    placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control currencies" id="currency_id" style="width: 100%;">
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" value="{{ $incomeType->amount }}" id="amount"
                                    placeholder="Enter details">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="active" class="custom-control-input" id="active"
                                        @if($incomeType->active) checked @endif>
                                    <label class="custom-control-label" for="active">Active Status</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" onclick="performUpdate({{ $incomeType->id }})"
                                class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- Toastr -->
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

<script>
    function performUpdate(id){
       let data = {
            name: document.getElementById ('name').value,
            amount: document.getElementById ('amount').value,
            currency_id: document.getElementById ('currency_id').value,
            active: document.getElementById('active').checked,
       }
       let redirectUrl = '{{ route('income-types.index') }}'
       update('/cms/admin/income-types/'+id, data, redirectUrl)
    }
</script>

@endsection
