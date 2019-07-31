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

                @if ( Session::has("error"))
                <div class="alert alert-danger">{{Session::get("error")}}</div>
                @endif

                @if ( Session::has("success"))
                <div class="alert alert-success">{{Session::get("success")}}</div>
                @endif
                <form class="form-horizontal" method="POST" action="{{url('pay')}}/{{$order->id}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h4 class="card-title">Pembayaran</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Nama Pelayan
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
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Pay
                            </label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('price') error @enderror" id="pay" name="price" placeholder="price" value="">
                                @error("price")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="table-responsive">
                                <table id="table-product" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Banyak</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        @foreach ( $order->item as $order )
                                        <tr>
                                            <td class="pr-5">{{$order->product->name}}</td>
                                            <td class="pr-5">{{$order->qty}}</td>
                                            <td class="pr-5">{{$order->product->price}}</td>
                                        </tr>
                                        @endforeach
        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary submit">Submit</button>
                                <a href="{{url('table')}}" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".submit").prop("disabled", true);
        $('#pay').keyup(function(){
            pay = $('#pay').val();
            price = $('#price').val();
            if (pay>=price) {
                $(".submit").prop("disabled", false);
            } else {
                $(".submit").prop("disabled", true);
            }
        })
    });
</script>
@endsection