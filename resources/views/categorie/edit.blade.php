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


                <form class="form-horizontal" method="POST" action='{{url("categorie/$categorie->id")}}'>
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <h4 class="card-title">Categorie Name</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                Categories Name
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="categorie name" value="@if(old('name')){{old('name')}}@else{{$categorie->name}}@endif">
                                @error('name')
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="fstatus" class="col-sm-3 text-right control-label col-form-label">
                                Categories Status
                            </label>
                            <div class="col-sm-9">

                                <input type="text" class="form-control @error('status') error @enderror" id="status" name="status" placeholder="categorie status" value="{{$categorie->status}}">

                                <select name="status" id="status" class="form-control">

                                    <option value="active" {{($categorie->status == 'active') ? 'selected' : '' }}>active</option>

                                    <option value="hide" {{($categorie->status == 'hide') ? 'selected' : '' }}>hide</option>

                                </select>

                                @error('status')
                                <div class="badge badge-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div> -->
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{url('dashboard/categorie')}}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection