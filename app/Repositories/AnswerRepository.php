<?php
namespace App\Repositories;

use App\Answer;

class AnswerRepository
{
    /**
     * Get all of the answers for a given question.
     *
     * @param  Question $question_id
     * @return Collection
     */
    public function forQuestion($question_id)
    {
        return Answer::where('answers.question_id', $question_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}