@extends('cms.parent')

@section('title','Currencies')
@section('page-name','Index Currencies')
@section('main-page','Currencies')
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
                                    <th>Status</th>
                                    <th>Is Deleted</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currencies as $currency)
                                {{-- {{ dd($currency) }} --}}
                                <tr>
                                    <td>{{ $currency->id }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td><span class="badge bg-success">{{ $currency->status }}</span></td>
                                    <td><span
                                            class="badge bg-success">{{ $currency->trashed() ? "True" : "False" }}</span>
                                    </td>
                                    <td>{{ $currency->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $currency->updated_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('currencies.edit',$currency->id) }}" type="button"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            @if(!$currency->trashed())
                                            <a href="#" class="btn btn-danger"
                                                onclick="performDestroy({{ $currency->id }}, this)"><i
                                                    class="fas fa-trash"></i></a>
                                            @endif
                                            @if($currency->trashed())
                                            <a href="#" class="btn btn-primary"
                                                onclick="restore({{ $currency->id }})"><i
                                                    class="fas fa-trash-restore"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $currencies->links() }}
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
<script src="{{ asset('js/crud.js') }}"></script>
<script>
    function performDestroy(id, td){
        confirmDestroy('/cms/admin/currencies/'+id, td)
    }

    function restore(id){
            axios.delete('/cms/admin/currencies/'+id+"/restore")
            .then(function (response) {
                console.log(response.data);
                showAlert(response.data);
            })
            .catch(function (error) {
                console.log(error.response);
                showAlert(error.response.data);
            })
            .then(function () {
                // always executed
            });
        }
</script>
@endsection
