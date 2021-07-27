@extends('cms.parent')

@section('title','Create City')
@section('page-name','Create City')
@section('main-page','Cities')
@section('sub-page','Create City')

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
                <h3 class="card-title">Chaneg Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="change-psasword-form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control" id="current_password" placeholder="Enter current password">
                  </div>
                  <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control" id="new_password" placeholder="Enter new password">
                  </div>
                  <div class="form-group">
                    <label for="new_password_confirmation">New Password Confirmation</label>
                    <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm new password">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="updatePassword()" class="btn btn-primary">Cahnge Password</button>
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
    <!-- bs-custom-file-input -->
    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Toastr -->
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>


<Script>
    function updatePassword(){
         axios.put('/cms/admin/update-password', {
             current_password: document.getElementById('current_password').value,
             new_password: document.getElementById('new_password').value,
             new_password_confirmation: document.getElementById('new_password_confirmation').value,
         })
         .then(function (response) {
             console.log(response);
             document.getElementById('change-psasword-form').reset();
             showToaster(response.data.message,true);
         })
         .catch(function (error) {
             console.log(error.response.data);
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
</Script>
@endsection
