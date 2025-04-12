<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['creator', 'users'])
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orWhere('created_by', Auth::id())
            ->paginate(10);

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $project = Project::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        
        $project->load(['creator', 'users', 'tasks']);
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
        ]);

        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        return response()->json(null, 204);
    }
} 