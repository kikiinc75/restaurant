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


                <form class="form-horizontal" method="POST" action="{{url('product')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">Product List</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Product Image
                            </label>
                            <div class="col-sm-9">

                                <!-- <input type="text" class="form-control @error('image') error @enderror" id="image" 
                                name="image" placeholder="image" value="{{old('image')}}"> -->

                                <input id="image" type="file" name="image" value="{{old('image')}}" class="form-control @error('image') error @enderror">


                                @error("image")
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Product Name
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="name" value="{{old('name')}}">
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
                                <input type="text" class="form-control @error('price') error @enderror" id="price" name="price" placeholder="price" value="{{old('price')}}">
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
                                    <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                                    @endforeach
                                </select>

                                @error("categorie_id")
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