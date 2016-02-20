<?php

use Illuminate\Database\Seeder;
use App\Topic;

class TopicSeeder extends Seeder{

    public function run(){
        DB::table('topics')->delete();

        Topic::create([
            'subject_id' => 1,
            'title'   => 'Objects and ADTs',
            'description'   => 'In this course, we won\'t delve into the full theory of object-oriented design. We\'ll concentrate on the pre-cursor of OO design: abstract data types (ADTs). A theory for the full object oriented approach is readily built on the ideas for abstract data types.'
        ]);

        Topic::create([
            'subject_id' => 1,
            'title'   => 'Constructors and destructors',
            'description'   => 'The create and destroy methods - often called constructors and destructors - are usually implemented for any abstract data type.'
        ]);

        Topic::create([
            'subject_id' => 1,
            'title'   => 'Data Structure',
            'description'   => 'To construct an abstract software model of a collection, we start by building the formal specification. The first component of this is the name of a data type - this is the type of objects that belong to the collection class.'
        ]);


        Topic::create([
            'subject_id' => 2,
            'title'   => 'Arrays',
            'description'   => 'The simplest way to implement our collection is to use an array to hold the items.'
        ]);

        Topic::create([
            'subject_id' => 2,
            'title'   => 'Lists',
            'description'   => 'The array implementation of our collection has one serious drawback: you must know the maximum number of items in your collection when you create it.'
        ]);

        Topic::create([
            'subject_id' => 2,
            'title'   => 'Stacks',
            'description'   => 'Another way of storing data is in a stack. A stack is generally implemented with only two principle operations (apart from a constructor and destructor methods)'
        ]);
    }
}
