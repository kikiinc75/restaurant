@extends("layouts.template")

@section("content")
<style>
    #table-product form {
        float: left
    }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">List Log Activity</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Log</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-product" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama User</th>
                                    <th>Log</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $logs as $log)
                                <tr>
                                    <td>{{$log->user->name}}</td>
                                    <td>{{$log->description}}</td>
                                </tr>
                                @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection