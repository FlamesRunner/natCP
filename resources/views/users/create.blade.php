@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card-box">
                    <form role="form" method="post" action="/admin/users">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name= "user_email" id="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" id="Username" name="user_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" placeholder="6 - 15 Characters" id="Password" name="password" class="form-control">
                        </div>
                        <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
@endsection