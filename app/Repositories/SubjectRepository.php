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
    public function forUser(User $user)
    {
        return Subject::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
