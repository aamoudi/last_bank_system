@extends('cms.parent')

@section('title','Admins')
@section('page-name','Index Admins')
@section('main-page','Admins')
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
                                    <th>F.Name</th>
                                    <th>L.Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Permissions</th>
                                    <th>City</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                {{-- {{ dd($admin) }} --}}
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->first_name }}</td>
                                    <td>{{ $admin->last_name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->mobile }}</td>
                                    <td><span class="badge bg-success">{{ $admin->gender_title }}</span></td>
                                    <td><a href="{{ route('admins.permissions.index',$admin->id) }}"
                                            class="btn btn-info">{{ $admin->permissions_count }} / Permissions <i
                                                class="fas fa-user-tie"></i></a></td>
                                    <td>{{ $admin->city->name }}</td>
                                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $admin->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admins.edit',$admin->id) }}" type="button"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            @if(Auth::user()->id != $admin->id)
                                            <a href="#" class="btn btn-danger"
                                                onclick="performDestroy({{ $admin->id }}, this)"><i
                                                    class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $admins->links() }}
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
        confirmDestroy('/cms/admin/admins/'+id, td)
    }
</script>
@endsection
