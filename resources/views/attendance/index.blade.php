@extends('adminlte::page')

@section('title', 'Attendance')

@section('content_header')
    <h1>Attendance</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>Mark Today's Attendance</h4>
                </div>
                <div class="box-body">
                    <div class="form-inline">
                        <label for="">Select Classroom:</label>
                        <select name="mark_classroom_id" id="mark_classroom_id" class="form-control" onchange="changeMarkClassroomLink()">
                            <option selected disabled value="#">Please Select Class</option>
                            @foreach($classrooms as $classroom)
                                @if(!$classroom->attendance_marked_today)
                                    <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <a href="#" id="mark_classroom_link"><button class="btn btn-primary form-control" >Select</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="box">
                <div class="box-header">
                    <h4>View Today's Attendance</h4>
                </div>
                <div class="box-body">
                    <div class="form-inline">
                        <label for="">Select Classroom:</label>
                        <select name="view_classroom_id" id="view_classroom_id" class="form-control" onchange="changeViewClassroomLink()">
                            <option selected  value="{{route('attendance.mark-today-attendance-by-class')}}">All Classes</option>
                            @foreach($classrooms as $classroom)
                                @if($classroom->attendance_marked_today)
                                    <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <a href="{{route('attendance.mark-today-attendance-by-class')}}" id="view_classroom_link"><button class="btn btn-primary form-control" >Select</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function changeMarkClassroomLink() {
            $("#mark_classroom_link").attr('href',"{{url('classrooms/mark-today-attendance')}}/"+$("#mark_classroom_id option:selected").val());
        }
        function changeViewClassroomLink() {
            $("#view_classroom_link").attr('href',"{{url('classrooms/view-today-attendance')}}/"+$("#view_classroom_id option:selected").val());
        }
    </script>
@endpush