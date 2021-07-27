@extends('cms.parent')

@section('title','Edit Profession')
@section('page-name','Edit Profession')
@section('main-page','Professions')
@section('sub-page','Edit Profession')

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
                <h3 class="card-title">Edit Profession</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="edit_form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $profession->name }}" id="name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" name="active" class="custom-control-input" id="active" @if($profession) checked @endif>
                      <label class="custom-control-label" for="active">Active Status</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" onclick="update({{ $profession->id }})" class="btn btn-primary">Save</button>
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
            axios.put('/cms/admin/professions/'+id, {
                name: document.getElementById ('name').value,
                active: document.getElementById('active').checked,
            })
            .then(function (response) {
                console.log(response);
                window.location.href = '{{ route('professions.index') }}';
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
