@extends('cms.parent')

@section('title','Edit Admin')
@section('page-name','Edit Admin')
@section('main-page','Admins')
@section('sub-page','Edit Admin')

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
                <h3 class="card-title">Edit Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="create_form">
                @csrf
                <div class="card-body">

                <div class="form-group">
                  <label>City</label>
                  <select class="form-control cities" id="city_id" style="width: 100%;">
                    {{-- <option selected="selected">Alabama</option> --}}
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @if($admin->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                    @endforeach
                  </select>
                </div>
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" value="{{ $admin->first_name }}" id="first_name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" value="{{ $admin->last_name }}" id="last_name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="{{ $admin->email }}" id="email" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="tel" class="form-control" value="{{ $admin->mobile }}" id="mobile" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="male" name="gender" @if($admin->gender == 'M') checked @endif>
                      <label for="male" class="custom-control-label">Male</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="female" name="gender"  @if($admin->gender == 'F') checked @endif>
                      <label for="female" class="custom-control-label">Female</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="update({{ $admin->id }})" class="btn btn-primary">Save</button>
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
    <!-- Select2 -->
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });

        //Initialize Select2 Elements
        $('.cities').select2({
        theme: 'bootstrap4'
        })
    </script>

    <script>
        function update(id){
            axios.put('/cms/admin/update-profile', {
                city_id: document.getElementById ('city_id').value,
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                mobile: document.getElementById('mobile').value,
                gender: document.getElementById('male').checked ? 'M' : 'F',
            })
            .then(function (response) {
                console.log(response);
                //document.getElementById('create_form').reset();
                showToaster(response.data.message, true);
            })
            .catch(function (error) {
                console.log(error.response);
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
