@extends('adminlte::page')

@section('title', 'Attendance')

@section('content_header')
    <h1>Mark Attendance</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 no-padding">
            <form action="{{route('attendance.store')}}" method="post">
                {{csrf_field()}}
                <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table  table-hover table-condensed" id="students_table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width: 20%">Present</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($students as $student)
                                <tr style="border: none" data-id="{{$student->id}}" onclick="markTick(this)">
                                    <td style="border: none">{{$student->name}}</td>
                                    <td style="border: none">
                                        <input type="hidden" name="students[]" value="{{$student->id}}">
                                        <input name="present[]" value="{{$student->id}}" type="checkbox" id="checkbox_{{$student->id}}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <center><input class="btn btn-primary" type="submit"></center>
                    </div>
            </div>

        </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function markTick(element) {
            var id=$(element).data("id");
            var checkBox=$("#checkbox_"+id);
            checkBox.prop("checked", !checkBox.prop("checked"));
        }
    </script>
@endpush