@extends('cms.parent')

@section('title','Income Types')
@section('page-name','Index')
@section('main-page','Income Types')
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
                <h3 class="card-title">Income Types</h3>

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
                      <th>Amount</th>
                      <th>Currency</th>
                      <th>Stauts</th>
                      <!-- <th>Status</th> -->
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i = 1;
                    @endphp
                      @foreach ($incomeTypes as $type)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->amount }}</td>
                            <td><span class="badge bg-success">{{ $type->currency->name }}</span></td>
                            <td id="transaction_flag"><span class="badge @if(!$type->transaction_flag == 0) bg-success @else bg-danger @endif">@if($type->transaction_flag == 0) Not transferred @else transferred @endif</span>
                            </td>
                            <!-- <td><span class="badge @if($type->status == 'Active') bg-success @else bg-danger @endif">{{ $type->status }}</span></td> -->
                            <td>{{ $type->created_at->format('Y-m-d') }}</td>
                            <td>{{ $type->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group">
                                    <!--<a href="{{ route('income-types.edit',$type->id) }}" type="button" class="btn btn-info"><i class="fas fa-edit"></i></a>-->
                                    <a href="#" class="btn btn-danger" onclick="confirmDestroy({{ $type->id }}, this)"><i class="fas fa-trash"></i></a>
                                    @if ($type->transaction_flag == 0)
                                      <a href="#" class="btn btn-info" onclick="confirmTransaction({{ $type->id }}, this)"><i class="fas fa-exchange-alt"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                  {{ $incomeTypes->links() }}
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
        function confirmTransaction(id, td){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                   transaction(id, td);
                }
            });
        }

        function destroy(id, td){
            axios.delete('/cms/admin/income-types/'+id)
            .then(function (response) {
                // handle success
                td.closest('tr').remove();
                showAlert(response.data);
            })
            .catch(function (error) {
                // handle error
                showAlert(error.response.data);
            })
            .then(function () {
                // always executed
            });
        }
        function transaction(id, td){
            axios.get('/cms/admin/wallettrans?type_id='+id)
            .then(function (response) {
                // handle success
                
                showAlert(response.data);
                location.reload(true);
            })
            .catch(function (error) {
                // handle error
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
