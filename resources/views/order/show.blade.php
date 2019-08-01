@extends("layouts.template")

@section("content")

<style>
    .error {
        background: #FF98A0;
    }
    #table-product form {
        float: left
    }
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Detail</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Nomor Nota
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="name" value="{{$order->order_number}}" readonly>
                                @error("name")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Nama Pelayan
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="name" value="{{$order->user->name}}" readonly>
                                @error("name")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Nomor Meja
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="name" value="{{$order->table->name}}" readonly>
                                @error("name")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Price
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('price') error @enderror" id="price" name="price" placeholder="price" value="{{$order->total_price}}" readonly>
                                @error("price")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Tambah Pesanan</button>
                        <br><br>
    
                    </div>
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
                                <table id="table-product" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Banyak</th>
                                            <th>Harga</th>
                                            <th>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        @foreach ( $order->item as $order )
                                        <tr>
                                            <td class="pr-5">{{$order->product->name}}</td>
                                            <td class="pr-5">{{$order->qty}}</td>
                                            <td class="pr-5">{{$order->product->price}}</td>
                                            <td>
                                                <form action='{{url("item/$order->id")}}' method="POST" id="table-product">
                                                    @method("delete")
                                                    @csrf
                                                    <button class="btn btn-primary" onClick="return confirm('yakin ?')">delete</button>
                                                </form>
                                                &nbsp
                                                <a href='{{url("item/$order->id/edit")}}'>
                                                    <button class="btn btn-success">Edit</button>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <a href="{{url('order')}}" class="btn btn-success">Back</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form-horizontal mt-3" method="POST" action="{{route('item.store')}}">
                @csrf
                <div class="form-group row">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                        product
                    </label>
                    <div class="col-sm-6">

                        <select name="product_id" id="product_id" class="form-control">
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}} - {{$product->price}}</option>
                            @endforeach
                        </select>

                        @error("product_id")
                        <div class="badge badge-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                        Table Name
                    </label>
                    <div class="col-sm-6">
                        <input type="hidden" name="order_id" value="{{$id}}">
                        <input type="number" class="form-control @error('qty') error @enderror" id="qty" name="qty" placeholder="qty" value="0" required>
                        @error("qty")
                        <div class="badge badge-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
        </div>
        </div>
    </div>
</div>
@endsection