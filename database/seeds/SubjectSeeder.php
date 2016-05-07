<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectSeeder extends Seeder{

    public function run(){
        DB::table('subjects')->delete();
        /*
         *
         *
        Subject::create([
            'user_id' => 1,
            'title'   => 'Programming Strategies',
            'description'   => 'It is necessary to have some formal way of constructing a program so that it can be built efficiently and reliably. Research has shown that this can be best done by decomposing a program into suitable small modules, which can themselves be written and tested before being incorporated into larger modules, which are in turn constructed and tested.'
        ]);

        Subject::create([
            'user_id' => 1,
            'title'   => 'Data Structures',
            'description'   => 'In this section, we will examine some fundamental data structures: arrays, lists, stacks and trees.'
        ]);


       Subject::create([
            'user_id' => 1,
            'title'   => 'Data Structures and Algorithms',
            'description'   => 'To learn techniques for the design and analysis of algorithms using fundamental data structures.'
        ]);

        Subject::create([
            'user_id' => 1,
            'title'   => 'Object-Oriented Programming',
            'description'   => 'To introduce the student to the fundamental concepts of object-oriented programming such as inheritance, polymorphism, code reuse and class-based modularization.'
        ]);
         */



    }
}
