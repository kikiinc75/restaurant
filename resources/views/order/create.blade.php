@extends("layouts.template")

@section("content")

<style>
    .error {
        background: #FF98A0;
    }   
</style>


<div class="container-fluid">
    <div class="row utama">
        <div class="col-7">
            <div class="card">

                @if ( Session::has("error"))
                <div class="alert alert-danger">{{Session::get("error")}}</div>
                @endif

                @if ( Session::has("success"))
                <div class="alert alert-success mb-2">{{Session::get("success")}}</div>
                @endif

                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-6 col-lg-3">
                        <div class="card">
                            @if($product->image)
                            <img class="card-img-top" src="{{url('uploads/file/'.$product->image)}}" alt="{{$product->name}}" style="height: 200px">
                            @else
                            <img class="card-img-top" src="{{url('uploads/file/default.jpg')}}" alt="{{$product->name}}" style="height: 200px">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{$product->name}}</h5>
                                <p class="card-text">Harga : {{$product->price}}</p>
                                <button class="btn btn-info add" data-id="{{$product->id}}" data-user="{{Auth::user()->id}}">tambah</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="table-responsive">
                <table class="table table-hover">
                    <div class="header text-right">
                        <button class="btn btn-success m-2 checkout" data-toggle="modal" data-target="#exampleModal">Checkout</button>
                    </div>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-cart">
                        </tbody>
                    </table>
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
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form-horizontal" method="POST" action="{{route('order.store')}}">
                @csrf
                <div class="form-group row mt-3">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                            Table
                        </label>
                        <div class="col-sm-5">

                            <select name="table" id="table_id" class="form-control">
                                @forelse ($tables as $table)
                                <option value="{{$table->id}}">{{$table->name}}</option>
                                @empty
                                <option>Tempat Tidak Tersedia</option>    
                                @endforelse
                            </select>

                            @error("categorie_id")
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
<script src="{{ asset('js/transaksi.js') }}"></script>
@endsection