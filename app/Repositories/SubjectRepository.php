<?php

namespace App\Repositories;

use App\User;
use App\Subject;

class SubjectRepository
{
    /**
     * Get all of the subjects for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forLectures($lecture_id)
    {
        return Subject::with('topics')
            ->where('subjects.lecture_id', $lecture_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
