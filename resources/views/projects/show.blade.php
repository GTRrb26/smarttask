<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $project->title }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Project
                </a>
                <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this project?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Delete Project
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Project Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Description</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium mb-2">Project Details</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Created by:</span> {{ $project->creator->name }}</p>
                                <p><span class="font-medium">Start Date:</span> {{ $project->start_date->format('M d, Y') }}</p>
                                <p><span class="font-medium">End Date:</span> {{ $project->end_date->format('M d, Y') }}</p>
                                <p><span class="font-medium">Status:</span> 
                                    @if($project->end_date->isPast())
                                        <span class="text-red-600 dark:text-red-400">Overdue</span>
                                    @else
                                        <span class="text-green-600 dark:text-green-400">In Progress</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-2">Team Members</h3>
                            <div class="space-y-2">
                                @foreach($project->users as $user)
                                    <div class="flex items-center justify-between">
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === $project->created_by)
                                            <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded">Owner</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tasks</h3>
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Task
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- To Do -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">To Do</h4>
                            @foreach($project->tasks->where('status', 'To Do') as $task)
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                                    <h5 class="font-medium mb-2">{{ $task->title }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Due: {{ $task->due_date->format('M d') }}</span>
                                        @if($task->assignedTo)
                                            <span class="text-gray-500 dark:text-gray-400">{{ $task->assignedTo->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- In Progress -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">In Progress</h4>
                            @foreach($project->tasks->where('status', 'In Progress') as $task)
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                                    <h5 class="font-medium mb-2">{{ $task->title }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Due: {{ $task->due_date->format('M d') }}</span>
                                        @if($task->assignedTo)
                                            <span class="text-gray-500 dark:text-gray-400">{{ $task->assignedTo->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Done -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-700 dark:text-gray-300">Done</h4>
                            @foreach($project->tasks->where('status', 'Done') as $task)
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                                    <h5 class="font-medium mb-2">{{ $task->title }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Due: {{ $task->due_date->format('M d') }}</span>
                                        @if($task->assignedTo)
                                            <span class="text-gray-500 dark:text-gray-400">{{ $task->assignedTo->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 