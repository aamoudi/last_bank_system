@extends('cms.parent')

@section('title','Create Profession')
@section('page-name','Create Profession')
@section('main-page','Professions')
@section('sub-page','Create Profession')

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
                        <h3 class="card-title">Create Profession</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    {{-- enctype="multipart/form-data" --}}
                    <form role="form" id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name">
                            </div>

                            {{-- <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <div class="input-group">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                          <span class="input-group-text" id="">Upload</span>
                      </div>
                      </div>
                  </div> --}}
                            <div class="form-group">
                                <label for="customFile">Custom File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profession-image">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="active" class="custom-control-input" id="active">
                                    <label class="custom-control-label" for="active">Active Status</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" onclick="store()" class="btn btn-primary">Save</button>
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
<!-- bs-custom-file-input -->
<script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
            bsCustomFileInput.init();
        });
</script>

<script>
    function store(){
            var formData = new FormData();
            formData.append('name',document.getElementById('name').value);
            formData.append('active',document.getElementById('active').value);
            if(document.getElementById('profession-image').files[0] != undefined){
                formData.append('image',document.getElementById('profession-image').files[0]);
            }
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ' => ' + pair[1]);
            }

            axios.post('/cms/admin/professions',formData)
            .then(function (response) {
                console.log(response);
                document.getElementById('create_form').reset();
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
