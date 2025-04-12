<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class ProjectKanban extends Component
{
    public $project;
    public $tasks;
    public $statuses = ['To Do', 'In Progress', 'Done'];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = $this->project->tasks()
            ->with('assignedTo')
            ->orderBy('order')
            ->get()
            ->groupBy('status');
    }

    public function updateTaskStatus($taskId, $status, $order)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->update([
                'status' => $status,
                'order' => $order
            ]);
        }
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.project-kanban');
    }
}
