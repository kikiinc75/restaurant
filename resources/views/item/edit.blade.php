@extends("layouts.template")

@section("content")

<style>
    .error {
        background: #FF98A0;
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


                <form class="form-horizontal" method="POST" action="{{url('item')}}/{{$item->id}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h4 class="card-title">item List</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                item Name
                            </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="order_id" value="{{$item->order_id}}">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="item name" value="@if(old('name')){{old('name')}}@else{{$item->product->name}}@endif" readonly>
                                @error("name")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Nomer Order
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="number" placeholder="item name" value="@if(old('name')){{old('name')}}@else{{$item->order->order_number}}@endif" readonly>
                                @error("name")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                price
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('price') error @enderror" id="price" name="price" placeholder="item price" value="@if(old('price')){{old('price')}}@else{{$item->product->price}}@endif" readonly>
                                @error("price")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Jumlah
                            </label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('qty') error @enderror" id="qty" name="qty" placeholder="item qty" value="@if(old('qty')){{old('qty')}}@else{{$item->qty}}@endif">
                                @error("qty")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url("order/$item->order_id")}}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection