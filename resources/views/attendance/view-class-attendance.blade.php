@extends('adminlte::page')

@section('title', 'Attendance')

@section('content_header')
    <h1>View Attendance</h1>
@stop
@php($absent=0)
@section('content')
    <div class="row">
        <div class="col-md-12 no-padding">
            <form action="{{route('attendance.update')}}" method="post" id="attendance_form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
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

                                @foreach($attendances as $attendance)
                                    <tr style="border: none" data-id="{{$attendance->id}}" onclick="markTick(this)" @if(!$attendance->present)class="danger"@endif>
                                        <td style="border: none">{{$attendance->student->name}}</td>
                                        <td style="border: none">
                                            <input type="hidden" name="attendances[]" value="{{$attendance->id}}">
                                            @if($attendance->present)
                                                <input name="present[]" value="{{$attendance->id}}" type="checkbox" checked id="checkbox_{{$attendance->id}}">
                                            @else
                                                <input name="present[]" value="{{$attendance->id}}" type="checkbox" id="checkbox_{{$attendance->id}}">
                                                @php($absent++)
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="pull-right">
                                    <h4><strong>Total:</strong> <div class="pull-right"> {{$attendances->count()}}</div></h4>
                                    <h4><strong>Present:</strong> <div class="pull-right"> {{$attendances->count()-$absent}}  ({{round((($attendances->count()-$absent)/$attendances->count())*100)}}%)</div></h4>
                                    <h4><strong>Absent:</strong> <div class="pull-right"> {{$absent}}  ({{round(($absent/$attendances->count())*100,3)}}%)</div></h4>
                                </div>
                            </div>
                            <div class="row no-print">
                                <center>
                                    <input class="btn btn-primary" type="submit">
                                    <button type="button" class="btn btn-success" onclick="sendAbsentSMS(this)">Send SMS</button>
                                </center>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function sendAbsentSMS(element) {
            var id=$(element).data('id');
            var url="{{url('attendance/send-sms')}}"+"/"+"{{$classroom_id}}";
            @if(!$classroom_id)
                  url="{{url('attendance/send-sms')}}";
            @endif
            swal({
                title: "Are you sure?",
                text: "Please make sure the attendance is correct!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSend) => {
                if (willSend) {

                    axios({
                        method:"POST",
                        url:url,
                        data:{
                            _token:"{{csrf_token()}}"
                        }
                    }).then(function (response) {
                        swal("Poof! messages hae been sent for processing!", {
                            icon: "success",
                        })
                    }).catch(function (error) {
                        swal("Error!", {
                            icon: "error",
                        });
                    });
                } else {
                    swal("Messages not sent Please review!");
                }
            });
        }
        function markTick(element) {
            var id=$(element).data("id");
            var checkBox=$("#checkbox_"+id);
            checkBox.prop("checked", !checkBox.prop("checked"));
        }
    </script>
@endpush