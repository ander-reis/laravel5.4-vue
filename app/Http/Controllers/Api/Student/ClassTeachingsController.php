<?php

namespace SON\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Models\ClassInformation;

class ClassTeachingsController extends Controller
{
    public function index(ClassInformation $classInformation)
    {
        $student = \Auth::user()->userable;
        $results = $student->classInformations()->find($classInformation->id)->teachings;

        return $results;
    }

    public function show(ClassInformation $classInformation, $id)
    {
        $student = \Auth::user()->userable;
        $result = $student->classInformations()->find($classInformation->id)->teachings()->findOrFail($id);

        return $result;
    }
}
