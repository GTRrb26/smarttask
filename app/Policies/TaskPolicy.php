<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $task->project->users->contains($user) || 
               $task->project->created_by === $user->id;
    }

    public function update(User $user, Task $task): bool
    {
        return $task->project->created_by === $user->id || 
               $task->assigned_to === $user->id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->project->created_by === $user->id;
    }
} 