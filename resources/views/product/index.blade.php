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
            <h4 class="page-title">List Product</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Product</li>
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

                    <a href="{{url('product/create')}}">
                        <button class="btn btn-success">New Product</button>
                    </a><br><br>

                    @if ( Session::has("success") )
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif

                    @if ( Session::has("error") )
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="table-product" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>image</th>
                                    <th>name</th>
                                    <th>price</th>
                                    <th>categorie</th>
                                    <th>status</th>
                                    <th width="200px">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                        <img src="{{url('uploads/file/'.$product->image)}}" style="height: 50px">
                                        @else
                                        <img src="{{url('uploads/file/default.jpg')}}" style="height: 50px">
                                        @endif
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->categorie->name}}</td>
                                    <td>
                                        @if($product->status==1)
                                        Ready
                                        @else
                                        Not Ready
                                        @endif</td>
                                    <td>

                                        <form action='{{url("product/$product->id")}}' method="POST">
                                            @method("delete")
                                            @csrf
                                            <button class="btn btn-primary" onClick="return confirm('yakin ?')">delete</button>
                                        </form>

                                        &nbsp
                                        <a href='{{url("product/$product->id")}}/edit'><button class="btn btn-success">edit</button></a>

                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        {{$products->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection