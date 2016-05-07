<?php

namespace App\Repositories;

use App\Lecture;
use App\User;

class LectureRepository
{
    /**
     * Get all of the subjects for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Lecture::with('subjects')
            ->where('lecture.user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
