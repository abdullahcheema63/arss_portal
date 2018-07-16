<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Student;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students=Student::with('classroom')->get();
        $classrooms=Classroom::all();
        return view('students.index',compact('students','classrooms'));
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
        $validatedData = $request->validate([
            'name' => 'required',
            'father_name'=>'required',
            "address"=>'required',
            'phone_number'=>'required|digits_between:9,16',
            'classroom_id'=>'required'
        ]);
        Student::create($validatedData);
        return redirect()->route('students.index')->with('success',"Student Created Successfully");

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
        $validatedData = $request->validate([
            'name' => 'required',
            'father_name'=>'required',
            "address"=>'required',
            'phone_number'=>'required|digits_between:9,16',
            'classroom_id'=>'required'
        ]);
        Student::find($id)->update($validatedData);
        return redirect()->route('students.index')->with('success',"Student Updated Successfully");
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
        Student::find($id)->delete();
        return response("deleted",200);
    }

    public function import(Request $request){
//        return $request->all();
        $file_request=$request->file;
        $filename=$file_request->getPathName();
//        $file=fopen($file_path,"r");
        $data = array();
        $header = null;

        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle)) !== false)
            {
                if (!$header)
                    $header = $row;
                else

                    $data[] = array('name'=>$row[0],'father_name'=>$row[1],"address"=>$row[2],'phone_number'=>$row[3],"classroom_id"=>$request->classroom_id);
            }
            fclose($handle);
        }

//        return $data;
        Student::insert($data);
        return response("uploaded",200);
    }

}
