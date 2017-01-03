<?php
namespace App\Repositories;

use App\Subject;

class AssignmentRepository
{
    public function forKnowledgeUnit($knowledgeunit_id)
    {
        return Assignment::with("questions")
            ->where('assignments.knowledge_unit_id', $knowledgeunit_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function isDone($assignment_id)
    {
        return 1;
    }
}