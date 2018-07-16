<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateClassroomForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('name','text',[
            'rules'=>'required|email'
        ])->add('submit','submit',[
            'attr'=>[
                'class'=>'btn btn-primary pull-right'
            ]
        ]);
    }
}
