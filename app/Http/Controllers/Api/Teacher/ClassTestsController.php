<?php

namespace SON\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Http\Requests\ClassTestRequest;
use SON\Models\ClassTeaching;
use SON\Models\ClassTest;

class ClassTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClassTeaching $classTeaching)
    {
        $results = ClassTest::where('class_teaching_id', $classTeaching->id)
            ->byTeacher(\Auth::user()->userable->id)
            ->get();

        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassTestRequest $request, ClassTeaching $classTeaching)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClassTeaching $classTeaching, ClassTest $classTest)
    {
        $result = ClassTest::byTeacher(\Auth::user()->userable->id)
            ->findOrFail($classTest->id);

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassTestRequest $request, ClassTeaching $classTeaching)
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
