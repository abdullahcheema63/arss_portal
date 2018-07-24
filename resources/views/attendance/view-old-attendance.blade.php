@extends('adminlte::page')

@section('title', 'Attendance')

@section('content_header')
    <h1>Attendance</h1>
@stop
@php
    $present=0;
    $absent=0;
    $total=0;
    $ttotal=0;
    $tabsent=0;
@endphp
@section('content')
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered custom-table m-b-0">
                            <thead>
                            <tr>
                                <th>Student Name</th>
                                @foreach($dates as $date)
                                    <th style="width: 3%">{{$date}}</th>
                                @endforeach
                                <th style="width: 3%"><center>Present</center></th>
                                <th style="width: 3%"><center>Absent</center></th>
                                <th style="width: 3%"><center>Total</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$student->name}}</td>
                                    @foreach($dates as $date)
                                        @if(array_key_exists($student->id,$attendances[$date]->toArray()))
                                            @if($attendances[$date][$student->id]->first()->present)
                                                <td><i class="fa fa-check text-success text-sm"></i></td>
                                                @php($present++)
                                            @else
                                                <td><i class="fa fa-close text-danger text-sm"></i></td>
                                                @php($absent++)
                                                @php($tabsent++)
                                            @endif
                                            @php($total++)
                                            @php($ttotal++)
                                        @else
                                            {{--<td><i class="fa fa-close text-danger text-sm"></i></td>--}}
                                            <td></td>
                                        @endif
                                    @endforeach
                                    <td><center>{{$total}}</center></td>
                                    <td><center>{{$present}}</center></td>
                                    <td><center>{{$absent}}</center></td>
                                </tr>
                                @php
                                $total=0;
                                $present=0;
                                $absent=0;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <strong>Absent Percentage:</strong>  <div class="pull-right">{{($tabsent/$ttotal)*100}}</div> <br>
                        <strong>Total Absents:</strong>  <div class="pull-right">{{$tabsent}}</div>
                        <br>
                        <strong>Total Attendance:</strong> <div class="pull-right">{{$ttotal}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection