@extends('adminlte::page')

@section('title', 'SMS')

@section('content_header')
    <h1>{{$value}} SMS</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="classrooms_table">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Message</th>


                                <th style="width: 20%">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($smss as $sms)
                                <tr>
                                    <td>{{$sms->number}}</td>
                                    <td>{{$sms->message}}</td>
                                    <td>{{$sms->status}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection