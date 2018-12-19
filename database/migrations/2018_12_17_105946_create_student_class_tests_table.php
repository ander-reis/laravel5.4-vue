<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentClassTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('class_test_id')->unsigned();
            $table->foreign('claa_test_id')->references('id')->on('class_tests');
            $table->float('point')->default(0);

            /**
             * chave de unicidade
             * não pode haver id repetido
             */
//            $table->unique(['student_id', 'class_test_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_class_tests');
    }
}
