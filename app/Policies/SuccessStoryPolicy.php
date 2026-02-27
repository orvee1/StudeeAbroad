<?php
namespace App\Policies;

use App\Models\SuccessStory;
use App\Models\User;

class SuccessStoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, SuccessStory $story): bool
    {
        return $user->isStudent() && (int) $story->user_id === (int) $user->id;
    }

    public function delete(User $user, SuccessStory $story): bool
    {
        return $user->isAdmin();
    }

    public function viewAdminList(User $user): bool
    {
        return $user->isAdmin();
    }
}
