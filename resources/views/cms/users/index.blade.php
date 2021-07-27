@extends('cms.parent')

@if (Auth::user()->hasRole('User'))
@section('title','Child') 
@section('page-name','Index Child')
@section('main-page','Child')
@else
@section('title','Users')
@section('page-name','Index Users')
@section('main-page','Users')
@endif


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
                        <h3 class="card-title">@if (Auth::user()->hasRole('User')) Child @else Users @endif</h3>

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
                                    <th>Professions</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email ?? '-'}}</td>
                                    <td>{{ $user->mobile ?? '-' }}</td>
                                    <td><span class="badge bg-success">{{ $user->gender_title }}</span></td>
                                    <td><span
                                            class="badge bg-info">{{ $user->profession->name ?? "No Profession" }}</span>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $user->city->name }}</span></td>
                                    <td><span
                                            class="badge @if($user->active) bg-success @else bg-danger @endif">{{ $user->status }}</span>
                                    </td>
                                    {{-- <td><a href="#" class="btn btn-info">{{ $user->permissions_count }} /
                                    Permissions <i class="fas fa-user-tie"></i></a></td> --}}
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $user->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit',$user->id) }}" type="button"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger"
                                                onclick="performDestroy({{ $user->id }}, this)"><i
                                                    class="fas fa-trash"></i></a>      
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $users->links() }}
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
        confirmDestroy('/cms/admin/users/'+id, td)
    }
</script>
@endsection
