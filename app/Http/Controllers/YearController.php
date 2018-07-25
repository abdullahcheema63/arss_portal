<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use Carbon\Carbon;
use Illuminate\Http\Request;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $years=AcademicYear::all();
        return view('year.index',compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date'
        ]);
        $start_date=Carbon::createFromFormat('Y-m-d',$request->start_date);
        $end_date=Carbon::createFromFormat('Y-m-d',$request->end_date);
        if ($end_date->diffInYears($start_date)){
            return redirect()->back()->with('error','Difference between start date and end date cannot be more then one year');
        }
        foreach (AcademicYear::all() as $year){
            $c_start_date=Carbon::createFromFormat('Y-m-d',$year->start_date);
            $c_end_date=Carbon::createFromFormat('Y-m-d',$year->end_date);
            if ($start_date>=$c_start_date && $start_date<=$c_end_date){
                return redirect()->back()->with('error','a year in this time span already exists');
            }
            if ($end_date>=$c_start_date && $end_date<=$c_end_date){
                return redirect()->back()->with('error','a year in this time span already exists');
            }
        }

        AcademicYear::create($request->all());
        return redirect()->back()->with('success','Academic Year Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
