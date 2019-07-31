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


                <form class="form-horizontal" method="POST" action="{{url('product')}}/{{$product->id}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h4 class="card-title">Product List</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Product Name
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="product name" value="@if(old('name')){{old('name')}}@else{{$product->name}}@endif">
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
                                <input type="text" class="form-control @error('price') error @enderror" id="price" name="price" placeholder="product price" value="@if(old('price')){{old('price')}}@else{{$product->price}}@endif">
                                @error("price")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Categorie
                            </label>
                            <div class="col-sm-9">
                                <select name="categorie_id" id="categorie_id" class="form-control">
                                    <option value="">-- silahkan pilih --</option>
                                    @foreach($list_categories as $categorie)
                                    <option value="{{$categorie->id}}" @if($product->categorie_id == $categorie->id) selected @endif>{{$categorie->name}}</option>
                                    @endforeach
                                </select>

                                @error("categorie_id")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Status
                            </label>
                            <div class="col-sm-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- silahkan pilih --</option>
                                    <option value="1" @if($product->status == 1) selected @endif>Ready</option>
                                    <option value="0" @if($product->status == 0) selected @endif>Not Ready</option>
                                </select>

                                @error("status")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('product')}}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection