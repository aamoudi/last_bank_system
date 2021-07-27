@extends('cms.parent')

@section('title','Edit Expense Type')
@section('page-name','Edit Expense Type')
@section('main-page','Expense Types')
@section('sub-page','Edit Expense Type')

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
                <h3 class="card-title">Create Currency</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="create_form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $expenseType->name }}" id="name" placeholder="Enter name">
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
                    <input type="text" class="form-control" value="{{ $expenseType->amount }}" id="amount" placeholder="Enter details">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" name="active" class="custom-control-input" id="active" @if($expenseType->active) checked @endif>
                      <label class="custom-control-label" for="active">Active Status</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="update({{ $expenseType->id }})" class="btn btn-primary">Save</button>
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
        function update(id){
            axios.put('/cms/admin/expense-types/'+id, {
                name: document.getElementById ('name').value,
                amount: document.getElementById ('amount').value,
                currency_id: document.getElementById ('currency_id').value,
                active: document.getElementById('active').checked,
            })
            .then(function (response) {
                window.location.href = '{{ route('expense-types.index') }}';
            })
            .catch(function (error) {
                showToaster(error.response.data.message, false);
            });
        }

        function showToaster(message, status){
            if(status){
                toastr.success(message);
            }else{
                toastr.error(message);
            }
        }
    </script>

@endsection
