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
            <h4 class="page-title">Order Active</h4>
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
                                        @if (Auth::user()->level=='kasir')
                                        <form action='{{url("order/$order->id")}}' method="POST">
                                            @method("delete")
                                            @csrf
                                            <button class="btn btn-danger" onClick="return confirm('yakin ?')">Batalkan Pesanan</button>
                                        </form>
                                        &nbsp
                                        <a href='{{url("order/$order->id/edit")}}'>
                                            <button class="btn btn-info">Pembayaran</button>
                                        </a>
                                        &nbsp
                                        @endif
                                        <a href='{{url("order/$order->id")}}'>
                                            <button class="btn btn-success">Detail</button>
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