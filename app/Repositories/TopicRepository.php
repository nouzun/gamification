<?php

namespace App\Repositories;

use App\Topic;
use App\Subject;

class TopicRepository
{
    /**
     * Get all of the topics for a given subject.
     *
     * @param  Subject  $subject
     * @return Collection
     */
    public function forSubject($subject_id)
    {
        return Topic::where('topics.subject_id', $subject_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
