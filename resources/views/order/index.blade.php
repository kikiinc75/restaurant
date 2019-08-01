@extends("layouts.template")


@section("content")

<style>
    #list_categories form {
        float: left;
    }
</style>


<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Categories</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categorie</li>
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

                    @if( Session::has("success"))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                    @endif

                    @if( Session::has("error"))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
                    @endif


                    <div class="table-responsive">
                        <table id="list_categories" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor Nota</th>
                                    <th>Pelayan</th>
                                    <th>Meja</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ( $orders as $order )
                                <tr>
                                    <td class="pr-5">{{$order->order_number}}</td>
                                    <td class="pr-5">{{$order->user->name}}</td>
                                    <td class="pr-5">{{$order->table->name}}</td>
                                    <td class="price">{{$order->total_price}}</td>
                                    <td class="pr-5">
                                        @if($order->status==1)
                                        Menunggu Bayar
                                        @endif
                                    </td>
                                    <td>
                                        <form action='{{url("order/$order->id")}}' method="POST">
                                            @method("delete")
                                            @csrf
                                            <button class="btn btn-primary" onClick="return confirm('yakin ?')">delete</button>
                                        </form>
                                        &nbsp
                                        <a href='{{url("order/$order->id")}}'>
                                            <button class="btn btn-success">Detail</button>
                                        </a>
                                        <a href='{{url("order/$order->id/edit")}}'>
                                            <button class="btn btn-info">Pembayaran</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{$orders->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection