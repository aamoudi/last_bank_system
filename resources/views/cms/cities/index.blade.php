@extends('cms.parent')

@section('title','Cities')
@section('page-name','Index Cities')
@section('main-page','Cities')
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
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

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
                      <th>Active</th>
                      <th>Admins Count</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($cities as $city)
                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->name }}</td>
                            {{-- @if($city->active)
                                <td>Active</td>
                            @else
                                <td>Not active</td>
                            @endif --}}
                            {{-- <td>@if($city->active) Active @else Not Active @endif</td> --}}
                            {{-- <span class="badge bg-success">90%</span> --}}
                            {{-- @if($city->active)
                                <td><span class="badge bg-success">{{ $city->status }}</span></td>
                            @else
                                <td><span class="badge bg-danger">{{ $city->status }}</span></td>
                            @endif --}}
                            <td><span @if($city->active) class="badge bg-success" @else class="badge bg-danger" @endif>{{ $city->status }}</span></td>
                            {{-- <td>{{ $city->status }}</td> --}}
                            <td><span class="badge bg-info">{{ $city->admins_count }} admin/s</span></td>
                            <td>{{ $city->created_at->format('Y-m-d') }}</td>
                            <td>{{ $city->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('Update-Cities')
                                    <a href="{{ route('cities.edit',$city->id) }}" type="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    {{-- <form role="form" method="POST" action="{{ route('cities.destroy',$city->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form> --}}

                                    {{-- <a href="{{ route('cities.destroy',$city->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}

                                    @can('Delete-Cities')
                                    <a href="#" class="btn btn-danger" onclick="confirmDestroy({{ $city->id }}, this)"><i class="fas fa-trash"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                  {{ $cities->links() }}
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
        function confirmDestroy(id, td){
            // console.log("WE ARE IN JS");
            // alert("WELCOME IN JS");
            console.log("CITY ID: "+id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    /*
                    -> Confirm:
                        1) Delete City (JS)
                        2) Delete Row from table
                        3) Show Success Alert
                    */
                   destroy(id, td);
                }
            });
        }

        function destroy(id, td){
            axios.delete('/cms/admin/cities/'+id)
            .then(function (response) {
                // handle success
                console.log(response.data);
                td.closest('tr').remove();
                showAlert(response.data);
            })
            .catch(function (error) {
                // handle error
                // console.log(error);
                console.log(error.response);
                showAlert(error.response.data);
            })
            .then(function () {
                // always executed
            });
        }

        function showAlert(data){
            // Swal.fire(
            //     data.title,
            //     data.message,
            //     data.icon
            // )

            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.icon,
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: false,
                willOpen: () => {
                    // Swal.showLoading()
                },
                willClose: () => {

                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
            });
        }
    </script>
@endsection
