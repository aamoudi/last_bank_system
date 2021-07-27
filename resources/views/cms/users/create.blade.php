@extends('cms.parent')
@if (Auth::user()->hasRole('User')) 
@section('title','Create Child')
@section('page-name','Create Child')
@section('main-page','Child')
@section('sub-page','Create Child')
@else 
@section('title','Create User')
@section('page-name','Create User')
@section('main-page','Users')
@section('sub-page','Create User')
@endif

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
                        <h3 class="card-title">@if (Auth::user()->hasRole('User')) Create Child @else Create User @endif</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="create_form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>City</label>
                                <select class="form-control cities" id="city_id" style="width: 100%;">
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Profession</label>
                                <select class="form-control professions" id="profession_id" style="width: 100%;">
                                    @foreach ($professions as $profession)
                                    <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="Enter first name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="Enter last name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="tel" class="form-control" id="mobile" placeholder="Enter moible">
                            </div>
                            <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="number" class="form-control" id="id_number" placeholder="Enter id number">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="male" name="gender" checked>
                                    <label for="male" class="custom-control-label">Male</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="female" name="gender">
                                    <label for="female" class="custom-control-label">Female</label>
                                </div>
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
        $('.cities').select2({
            theme: 'bootstrap4'
        });
        $('.professions').select2({
            theme: 'bootstrap4'
        })
</script>

<script>
    function performStore(){
        let data = {
            city_id: document.getElementById ('city_id').value,
            profession_id: document.getElementById ('profession_id').value,
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            mobile: document.getElementById('mobile').value,
            id_number: document.getElementById('id_number').value,
            gender: document.getElementById('male').checked ? 'M' : 'F'
        }
        store('/cms/admin/users', data)
    }
</script>

@endsection
