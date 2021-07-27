@extends('cms.parent')

@section('title','Professions')
@section('page-name','Index Professions')
@section('main-page','Professions')
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
                <h3 class="card-title">Professions</h3>

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
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($professions as $profession)
                        <tr>
                            <td>{{ $profession->id }}</td>
                            <td>{{ $profession->name }}</td>
                            <td><span class="badge bg-success">{{ $profession->status }}</span></td>
                            <td>{{ $profession->created_at->format('Y-m-d') }}</td>
                            <td>{{ $profession->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('professions.edit',$profession->id) }}" type="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" onclick="confirmDestroy({{ $profession->id }}, this)"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                  {{ $professions->links() }}
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
                   destroy(id, td);
                }
            });
        }

        function destroy(id, td){
            axios.delete('/cms/admin/professions/'+id)
            .then(function (response) {
                // handle success
                console.log(response.data);
                td.closest('tr').remove();
                showAlert(response.data);
            })
            .catch(function (error) {
                // handle error
                console.log(error.response);
                showAlert(error.response.data);
            })
            .then(function () {
                // always executed
            });
        }

        function showAlert(data){
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
