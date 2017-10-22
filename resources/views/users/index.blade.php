@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if(isset($message))
                    {{dd($message)}}
                @endif
                <div class="card-box table-responsive">

                    <h4 class="m-t-0 header-title"><b>User List</b></h4>
                    <p class="text-muted font-13 m-b-30">
                        List of all users
                    </p>
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Permission</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="/admin/users/{{$user->user_id}}">{{$user->user_name}}</a></td>
                                <td>{{$user->user_email}}</td>
                                <td>{{$user->permission_level}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-sm btn-primary waves-effect waves-light w-md" href="/admin/users/create" type="submit"><i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
        </div>

    </div>



@endsection



@section('scripts')
    <!-- Datatables-->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="/plugins/datatables/dataTables.fixedHeader.min.js"></script>


    <script src="/assets/js/jquery.core.js"></script>
    <script src="/assets/js/jquery.app.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
        } );

    </script>

@endsection
