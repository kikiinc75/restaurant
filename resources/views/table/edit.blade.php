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


                <form class="form-horizontal" method="POST" action="{{url('table')}}/{{$table->id}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h4 class="card-title">table List</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                table Name
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') error @enderror" id="name" name="name" placeholder="table name" value="@if(old('name')){{old('name')}}@else{{$table->name}}@endif">
                                @error("name")
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
                                    <option value="1" @if($table->status == 1) selected @endif>Ready</option>
                                    <option value="0" @if($table->status == 0) selected @endif>Not Ready</option>
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
                            <a href="{{url('table')}}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection