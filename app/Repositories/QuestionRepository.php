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
    public function forKnowledgeUnit($knowledgeunit_id)
    {
        return Question::where('questions.knowledge_unit_id', $knowledgeunit_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}