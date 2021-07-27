@extends('cms.parent')

@section('title','Edit Wallet')
@section('page-name','Edit Wallet')
@section('main-page','Wallets')
@section('sub-page','Edit Wallet')

@section('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                        <h3 class="card-title">Edit Wallet</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control currencies" id="currency_id" style="width: 100%;">
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" @if($wallet->currency_id == $currency->id)
                                        selected @endif>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $wallet->name }}"
                                    placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="balance">Balance</label>
                                <input type="number" class="form-control" id="balance" value="{{ $wallet->balance }}"
                                    placeholder="Enter balance (Optional)">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="active" class="custom-control-input"
                                        @if($wallet->active) checked @endif id="active">
                                    <label class="custom-control-label" for="active">Active Status</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" onclick="performUpdate({{ $wallet->id }})"
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
<!-- Select2 -->
<script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    //Initialize Select2 Elements
        $('.cities').select2({
            theme: 'bootstrap4'
        })
        $('.professions').select2({
            theme: 'bootstrap4'
        })
</script>

<script>
    function performUpdate(id){
        let data = {
            currency_id: document.getElementById('currency_id').value,
            name: document.getElementById('name').value,
            balance: document.getElementById('balance').value,
            active: document.getElementById('active').checked,
        }
        let redirectUrl = '{{ route('wallets.index') }}'
        console.log('URL: '+redirectUrl);
        update('/cms/admin/wallets/'+id, data, redirectUrl);
    }
</script>

@endsection
