<?php

namespace App\Policies;
use Log;
use App\Subject;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function destroy(User $user, Subject $subject)
    {
        Log::info('Showing user profile for user: '.$subject->user_id.' $user->id: ' . $user->id);
        return $user->id === $subject->user_id;
    }
}
