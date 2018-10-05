@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">{{ ucfirst('doacoes') }}</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ ucfirst('doacoes') }}
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-striped" id="thegrid">
              <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Usuario Id</th>
                    <th>Descricao</th>
                    <th>Bairro Id</th>
                    <th>Categoria Id</th>
                    <th>Aprovado</th>
                    <th>Doado</th>
                    <th style="width:50px"></th>
                    <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        <a href="{{url('doacoes/create')}}" class="btn btn-primary" role="button">Adicionar doação</a>
    </div>
</div>

@endsection



@section('scripts')
    <script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "responsive": true,
                "ajax": "{{url('doacoes/grid')}}",
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/doacoes') }}/'+row[0]+'">'+data+'</a>';
                        },
                        "targets": 1
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/doacoes') }}/'+row[0]+'/edit" class="btn btn-default">Update</a>';
                        },
                        "targets": 11                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                        },
                        "targets": 11+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/doacoes') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection