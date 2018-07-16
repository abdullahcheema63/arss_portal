@extends('adminlte::page')

@section('title', 'Students')

@section('content_header')
    <h1>Students</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="box">
                <div class="box-header">

                    <div class="form-inline ">
                        <div class="pull-left">
                            <div class="form-group">
                                <label for="classroom">Classroom:</label>
                                <select name="classroom_id" class="form-control" id="import_classroom_select_id">
                                    @foreach($classrooms as $classroom)
                                        <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-import">
                                    <i class=" fa fa-upload"></i>
                                    Import
                                </button>
                            </div>

                        </div>
                        <div class="pull-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                                    <i class=" fa fa-plus"></i>
                                    Create
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-condensed" id="students_table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Father's Name</th>
                                <th>Phone Number</th>
                                <th>Classroom</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->father_name}}</td>
                                    <td>{{$student->phone_number}}</td>

                                    <td>@if ($student->classroom){{$student->classroom->name}}@else {{"Please Edit and assign"}}@endif </td>

                                    <td>
                                        <a href="#modal-edit-student" data-toggle="modal" onclick="editStudentShowModal(this)" data-obj="{{$student}}">
                                            <i data-toggle="tooltip" title="Edit" class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <a onclick="event.preventDefault();deleteStudent(this)" data-id="{{$student->id}}">
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
            <form action="{{route('students.store')}}" method="POST">
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Create Student</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="father_name">Father Name:</label>
                            <input type="text" class="form-control" name="father_name">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address" class="form-control" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" class="form-control" name="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="classroom">Classroom:</label>
                            <select name="classroom_id" class="form-control">
                                @foreach($classrooms as $classroom)
                                    <option value="{{$classroom->id}}" data-id="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endforeach
                            </select>
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
    <div class="modal fade" id="modal-import" style="display: none;">
        <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Import Students</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('students.import')}}" class="dropzone" id="students-import-dropzone">
                            {{csrf_field()}}
                            <input type="hidden" name="classroom_id" id="import_classroom_id">
                        </form>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-edit-student" style="display: none;">
        <div class="modal-dialog">
            <form action="" method="POST" id="form-edit-student">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Edit Student</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" id="form-edit-student-name">
                        </div>
                        <div class="form-group">
                            <label for="father_name">Father Name:</label>
                            <input type="text" class="form-control" name="father_name" id="form-edit-student-father_name">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address" class="form-control" id="form-edit-student-address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" class="form-control" name="phone_number" id="form-edit-student-phone_number">
                        </div>
                        <div class="form-group">
                            <label for="classroom">Classroom:</label>
                            <select name="classroom_id" class="form-control" id="form-edit-student-classroom_id">
                                @foreach($classrooms as $classroom)
                                    <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endforeach
                            </select>
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
        var student_obj;
        function editStudentShowModal(element) {
            student_obj=$(element).data('obj');
            $("#form-edit-student").attr('action',"{{url('students')}}"+"/"+student_obj.id);
            $("#form-edit-student-name").val(student_obj.name);
            $("#form-edit-student-father_name").val(student_obj.father_name);
            $("#form-edit-student-address").val(student_obj.address);
            $("#form-edit-student-classroom_id").val(student_obj.classroom_id);
            $("#form-edit-student-phone_number").val(student_obj.phone_number);
        }
        function deleteStudent(element) {
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
                        url:"{{url('students')}}"+"/"+id,
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
        $(document).ready(function () {
            $("#modal-import").on('show.bs.modal',function () {
                $("#import_classroom_id").val($("#import_classroom_select_id option:selected").val())
            })
            $("#students_table").DataTable();
        })

    </script>
@endpush
