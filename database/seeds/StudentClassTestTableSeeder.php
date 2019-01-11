<?php

use Illuminate\Database\Seeder;

class StudentClassTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //retorna coleção de provas do professor id=1
        $classTests = \SON\Models\ClassTest::byTeacher(1)->get();

        foreach ($classTests as $classTest){
            //retorna professor
            $classTeaching = $classTest->classTeaching;

            //retorna turma
            $classInformation = $classTeaching->classInformation;

            //retorna alunos
            $students = $classInformation->students;

            //cria int de 70% dos alunos
            $totalStudents = (int)($students->count() * 0.7);

            //pega somente 70% dos alunos
            $studentsRandom = $students->random($totalStudents);

            //pega metade dos 70% dos alunos
            $halfStudents = $studentsRandom->count() / 2;

            //da metade acertará 100% das questões
            $studentsRandom100 = $studentsRandom->slice(0, $halfStudents);

            //pego contexto do $this para passar no each, não dá para passar $this diretamente
            $self = $this;

            //faz inclusão do alunos que acertaram 100%
            $studentsRandom100->each(function ($student) use($self, $classTest){
                //perc =>  1 = 100%; 0.6 = 60%
                $self->makeResults($student, $classTest, 1);
            });

            //da metade acerterá 60% das questões
            $studentsRandom60 = $studentsRandom->slice($halfStudents, $studentsRandom->count());

            //faz inclusão do alunos que acertaram 60%
            $studentsRandom60->each(function ($student) use($self, $classTest){
                //perc =>  1 = 100%; 0.6 = 60%
                $self->makeResults($student, $classTest, 0.6);
            });
        }
    }

    public function makeResults($student, $classTest, $perc)
    {
        //pega questões
        $questions = $classTest->questions;

        //pega o número de questões corretas de acordo com perc passado
        $numQuestionsCorrect = (int)($questions->count() * $perc);

        //número de questões corretas
        $questionsCorrect = $questions->slice(0, $numQuestionsCorrect);

        //número de questões erradas
        $questionsIncorrect = $questions->slice($numQuestionsCorrect, $questions->count());

        //array de escolhas
        $choices = [];

        //cria questões corretas
        foreach ($questionsCorrect as $question){
            $choices[] = [
                'question_id' => $question->id,
                'question_choice_id' => $question->choices->first()->id
            ];
        }

        //cria questões erradas
        foreach ($questionsIncorrect as $question){
            $choices[] = [
                'question_id' => $question->id,
                'question_choice_id' => $question->choices->last()->id
            ];
        }

        /**
         * no uso de seeder é por padrão desabilitado o uso de fillable do guardião do model
         */
        //habilita fillable do guardião
        \Illuminate\Database\Eloquent\Model::reguard();

        //cadastra escolhas
        \SON\Models\StudentClassTest::createFully([
            'class_test_id' => $classTest->id,
            'student_id' => $student->id,
            'choices' => $choices
        ]);

        //desabilita fillable do guardião
        \Illuminate\Database\Eloquent\Model::unguard();
    }
}
