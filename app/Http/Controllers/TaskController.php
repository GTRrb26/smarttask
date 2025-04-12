<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        $projects = Project::all();
        $selectedProjectId = $request->query('project_id');
        
        // If project_id is provided, ensure it exists
        if ($selectedProjectId && !Project::where('id', $selectedProjectId)->exists()) {
            $selectedProjectId = null;
        }
        
        return view('tasks.create', [
            'projects' => $projects,
            'selectedProjectId' => $selectedProjectId
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Format the date to ensure it's in the correct format
        $validated['due_date'] = Carbon::parse($validated['due_date'])->format('Y-m-d');

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:To Do,In Progress,Done',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
