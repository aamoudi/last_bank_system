@extends('cms.parent')

@section('title','Create Transaction')
@section('page-name','Create Transaction')
@section('main-page','Transactions')
@section('sub-page','Create Transaction')

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
                        <h3 class="card-title">Create Transaction</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Child</label>
                                <select class="form-control users" id="user_id" style="width: 100%;">
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter the amount">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="wallet_id" placeholder="Enter the amount" value="{{ $wallet_id }}">
                            </div>
                           
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" onclick="performStore()" class="btn btn-primary">Save</button>
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
        $('.currencies').select2({
            theme: 'bootstrap4'
        });
</script>

<script>
    function performStore(){
        let data = {
            amount: document.getElementById('amount').value,
            wallet_id: document.getElementById('wallet_id').value,
            user_id: document.getElementById('user_id').value,
        }
        store('/cms/admin/transaction', data)
    }
</script>

@endsection