@extends('layouts.master-no-container')

@section('title')
	Account
@endsection

@section('content')
        

	<section class="row new-post">
        <div class="col-md-3 pull-md-9">
            <div class="clearfix">

            <img src="{{ route('account.image', ['filename' => 'default.jpg']) }}" class = "responsive img-circle" style=" width: 100%; height:100%;">
            </div>
        </div>
        <div class="col-md-9 push-md-3">
            <header><h3>{{$user->first_name}}'s Account</h3></header>

            <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" id="first_name">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" id="last_name">

                    <label for="image">Update Profile Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Save Account</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>
    
   

@endsection