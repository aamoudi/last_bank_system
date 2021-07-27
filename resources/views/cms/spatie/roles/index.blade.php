@extends('cms.parent')

@section('title','Roles')
@section('page-name','Index Roles')
@section('main-page','Roles')
@section('sub-page','Index')

@section('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Cities</h3>

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
                                    <th>Permissions</th>
                                    <th>Created At</th>
                                    <th>  At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td><span class="badge bg-success">{{ $role->guard_name }}</span></td>
                                    <td><a href="{{ route('role.permissions.index',$role->id) }}"
                                            class="btn btn-info">{{ $role->permissions_count }} /
                                            Permissions <i class="fas fa-user-tie"></i></a></td>
                                    <td>{{ $role->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $role->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('roles.edit',$role->id) }}" type="button"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger"
                                                onclick="performDestroy({{ $role->id }}, this)"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $roles->links() }}
                        {{-- {{ $cities->render }} --}}
                    </div>
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
<script>
    function performDestroy(id, td){
        confirmDestroy('/cms/admin/roles/'+id, td)
    }
</script>
@endsection
