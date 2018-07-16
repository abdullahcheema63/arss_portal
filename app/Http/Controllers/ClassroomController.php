<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Forms\CreateClassroomForm;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        //
        $classrooms=Classroom::all();
        $form=$formBuilder->create(CreateClassroomForm::class,[
            'method'=>'POST',
            'url'=>route('classrooms.store')
        ]);
        return view('classrooms.index',compact('classrooms','form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return redirect()->route('classrooms.index');
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
            'name' => 'required'
        ]);
        Classroom::create($validatedData);
        return redirect()->route('classrooms.index')->with('success',"Classroom Created Successfully");

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
        return Classroom::find($id);
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
            'name' => 'required'
        ]);
        Classroom::find($id)->update($validatedData);
        return redirect()->route('classrooms.index')->with('success',"Classroom Updated Successfully");

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
        Classroom::find($id)->delete();
        return response("deleted",200);
    }
}
