@extends('adminlte::page')

@section('title', 'Classrooms')

@section('content_header')
    <h1>Classrooms</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="box">
                <div class="box-header">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-create">
                        <i class=" fa fa-plus"></i>
                        Create
                    </button>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="classrooms_table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classrooms as $classroom)
                                <tr>
                                    <td>{{$classroom->name}}</td>
                                    <td>
                                        <a href="#modal-edit-classroom" data-toggle="modal" onclick="editClassroomShowModal(this)" data-obj="{{$classroom}}">
                                            <i data-toggle="tooltip" title="Edit" class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <a onclick="event.preventDefault();deleteClassroom(this)" data-id="{{$classroom->id}}">
                                            <i data-toggle="tooltip" title="Delete" class="fa fa-trash fa-2x text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-create" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('classrooms.store')}}" method="POST">
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Create Classroom</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-edit-classroom" style="display: none;">
        <div class="modal-dialog">
            <form action="" method="POST" id="form-edit-classroom">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Edit Classroom</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" id="form-edit-classroom-name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@push('js')
    <script>
        var classroom_obj;
        function editClassroomShowModal(element) {
            classroom_obj=$(element).data('obj');
            $("#form-edit-classroom").attr('action',"{{url('classrooms')}}"+"/"+classroom_obj.id);
            $("#form-edit-classroom-name").val(classroom_obj.name);
        }
        function deleteClassroom(element) {
            var id=$(element).data('id');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        method:"DELETE",
                        url:"{{url('classrooms')}}"+"/"+id,
                        data:{
                            _token:"{{csrf_token()}}"
                        }
                    }).then(function (response) {
                        swal("Poof! class has been deleted!", {
                            icon: "success",
                        }).then(function (d) {
                            document.location.reload();
                        });
                    }).catch(function (error) {
                        swal("Error!", {
                            icon: "error",
                        });
                    });
                } else {
                    swal("Your class is safe!");
                }
            });
        }

        
        
    </script>
@endpush