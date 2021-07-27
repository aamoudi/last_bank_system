@extends('cms.parent')

@section('title','Users')
@section('page-name','Index Debits')
@section('main-page','Debits')
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
                        <h3 class="card-title">Debits</h3>

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
                                    <th>Total</th>
                                    <th>Remain
                                    <th>Type</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                    <th>Currency</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($debits as $debit)
                                {{-- <tr>
                                    <td>{{ $wallet->id }}</td>
                                <td>{{ $wallet->name }}</td>
                                <td><span class="badge bg-info">{{ $wallet->balance }}</span></td>
                                <td><span class="badge bg-success">{{ $wallet->currency->name }}</span></td>
                                <td><span
                                        class="badge @if($wallet->active) bg-success @else bg-danger @endif">{{ $wallet->status }}</span>
                                </td>
                                <td>{{ $wallet->created_at->format('Y-m-d') }}</td>
                                <td>{{ $wallet->updated_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('wallets.edit',$wallet->id) }}" type="button"
                                            class="btn btn-info"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger"
                                            onclick="performDestroy({{ $wallet->id }}, this)"><i
                                                class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $debits->links() }}
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
        confirmDestroy('/cms/admin/wallets/'+id, td)
    }
</script>
@endsection