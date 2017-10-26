@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <h4 class="m-t-0 header-title"><b>Node Management</b></h4>
                    <p class="text-muted font-13 m-b-30">
                        List of all slave nodes
                    </p>

                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Hostname</th>
                            <th>Access Key</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach($nodes as $node)
                            <tr>
                                <td><a href="/admin/nodes/{{$node->id}}">{{$node->hostname}}</a></td>
                                <td>{{$node->accesskey}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-sm btn-primary waves-effect waves-light w-md" href="/admin/nodes/create" type="submit"><i class="fa fa-plus"></i> Add Node</a>
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
