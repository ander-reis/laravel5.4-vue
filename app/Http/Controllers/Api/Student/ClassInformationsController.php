<?php

namespace SON\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Models\ClassInformation;

class ClassInformationsController extends Controller
{
    public function index()
    {
        //exemplo com relacionamento
        $student = \Auth::user()->userable;
        $results = $student->classInformations;

        //$results = ClassInformation::byStudent(\Auth::user()->userable->id)->get();


        return $results;
    }

    public function show($id)
    {
        //exemplo com relacionamento
        $student = \Auth::user()->userable;
        $result = $student->classInformations()->findOrFail($id);

        //$result = ClassInformation::byStudent(\Auth::user()->userable->id)->findOrFail($id);

        return $result;
    }
}
