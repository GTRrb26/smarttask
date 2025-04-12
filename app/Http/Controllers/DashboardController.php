<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get projects where user is either creator or member
        $projects = Project::where(function($query) use ($user) {
            $query->where('created_by', $user->id)
                  ->orWhereHas('users', function($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        })->latest()->take(5)->get();
        
        // Get tasks where user is either assigned to or part of the project
        $tasks = Task::where(function($query) use ($user) {
            $query->where('assigned_to', $user->id)
                  ->orWhereHas('project', function($q) use ($user) {
                      $q->where('created_by', $user->id)
                        ->orWhereHas('users', function($subq) use ($user) {
                            $subq->where('user_id', $user->id);
                        });
                  });
        })->with('project')->latest()->take(5)->get();
        
        $stats = [
            'total_projects' => Project::where(function($query) use ($user) {
                $query->where('created_by', $user->id)
                      ->orWhereHas('users', function($q) use ($user) {
                          $q->where('user_id', $user->id);
                      });
            })->count(),
            'total_tasks' => Task::where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('project', function($q) use ($user) {
                          $q->where('created_by', $user->id)
                            ->orWhereHas('users', function($subq) use ($user) {
                                $subq->where('user_id', $user->id);
                            });
                      });
            })->count(),
            'completed_tasks' => Task::where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('project', function($q) use ($user) {
                          $q->where('created_by', $user->id)
                            ->orWhereHas('users', function($subq) use ($user) {
                                $subq->where('user_id', $user->id);
                            });
                      });
            })->where('status', 'Done')->count(),
            'in_progress_tasks' => Task::where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('project', function($q) use ($user) {
                          $q->where('created_by', $user->id)
                            ->orWhereHas('users', function($subq) use ($user) {
                                $subq->where('user_id', $user->id);
                            });
                      });
            })->where('status', 'In Progress')->count(),
        ];

        return view('dashboard', compact('projects', 'tasks', 'stats'));
    }
}
