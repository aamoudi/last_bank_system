@extends('cms.parent')

@section('title','Permissions')
@section('page-name','Index Permissions')
@section('main-page','Permissions')
@section('sub-page','Index')

@section('styles')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permissions</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td><span class="badge bg-info">{{ $permission->name }}</span></td>
                                    <td><span class="badge bg-success">{{ $permission->guard_name }}</span></td>
                                    <td>
                                        <div class="icheck-success d-inline">
                                            <input type="checkbox" @if($permission->is_active) checked @endif
                                            onclick="performStore({{ $roleId }}, {{ $permission->id }})"
                                            id="permission_{{ $permission->id }}">
                                            <label for="permission_{{ $permission->id }}">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{-- {{ $permissions->links() }} --}}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
</section>
@endsection

@section('scripts')
<!-- Toastr -->
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

<script>
    function performStore(roleId,permissionId){
        let data = {
            permission_id: permissionId,
        }
        store('/cms/admin/role/'+roleId+'/permissions', data)
    }
</script>
@endsection
