<?php
namespace App\Repositories;

use App\Question;

class QuestionRepository
{
    /**
     * Get all of the questions for a given knowledge unit.
     *
     * @param  Knowledge Unit $knowledgeunit_id
     * @return Collection
     */
    public function forAssignment($assigment_id)
    {
        return Question::with("answers")
            ->where('questions.assignment_id', $assigment_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function forQuiz($quiz_id)
    {
        return Question::with("answers")
            ->where('questions.quiz_id', $quiz_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}