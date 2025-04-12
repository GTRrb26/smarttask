<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedTo'])
            ->whereHas('project', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->orWhere('created_by', Auth::id());
            });

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->has('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }

        if ($request->has('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        // Apply sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Done',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'required|date',
            'order' => 'nullable|integer',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        
        $task->load(['project', 'assignedTo', 'comments', 'files']);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:To Do,In Progress,Done',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'sometimes|date',
            'order' => 'nullable|integer',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $task->delete();
        return response()->json(null, 204);
    }
} 