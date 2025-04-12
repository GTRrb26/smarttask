<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        $this->authorize('view', $task);
        
        $comments = $task->comments()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($comments);
    }

    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $task->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validated);
        return response()->json($comment->load('user'));
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        return response()->json(null, 204);
    }
} 