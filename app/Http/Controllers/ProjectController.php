<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Project::class);
        
        $projects = Project::withCount('tasks')
            ->with(['creator', 'users'])
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orWhere('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['created_by'] = Auth::id();

        $project = Project::create($validated);

        // Add the creator as a project member
        $project->users()->attach(Auth::id());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);
        
        $project->load(['creator', 'users', 'tasks']);
        $availableUsers = User::whereNotIn('id', $project->users->pluck('id'))
            ->where('id', '!=', Auth::id())
            ->get();

        return view('projects.show', compact('project', 'availableUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function assignUser(Request $request, Project $project)
    {
        $this->authorize('assignUser', $project);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $project->assignUser($user);

        return back()->with('success', 'User assigned to project successfully.');
    }

    public function removeUser(Project $project, User $user)
    {
        $this->authorize('removeUser', $project);
        
        $project->removeUser($user);

        return back()->with('success', 'User removed from project successfully.');
    }
}
