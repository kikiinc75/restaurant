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
                    <a href="{{url('categorie/create')}}">
                        <button class="btn btn-success">Insert New Categorie</button>
                    </a><br><br>

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
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ( $list_categories as $categorie )
                                <tr>
                                    <td class="pr-5">{{$categorie->name}}</td>
                                    <td>
                                        <form action='{{url("categorie/$categorie->id")}}' method="POST">
                                            @method("delete")
                                            @csrf
                                            <button class="btn btn-primary" onClick="return confirm('yakin ?')">delete</button>
                                        </form>
                                        &nbsp
                                        <a href='{{url("categorie/$categorie->id/edit")}}'>
                                            <button class="btn btn-success">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{$list_categories->links()}}


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection