<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 dark:text-gray-400">{{ __('Total Projects') }}</div>
                        <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_projects'] }}</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 dark:text-gray-400">{{ __('Total Tasks') }}</div>
                        <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_tasks'] }}</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 dark:text-gray-400">{{ __('Completed Tasks') }}</div>
                        <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['completed_tasks'] }}</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 dark:text-gray-400">{{ __('In Progress Tasks') }}</div>
                        <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['in_progress_tasks'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Recent Projects') }}</h3>
                    <div class="space-y-4">
                        @forelse($projects as $project)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <a href="{{ route('projects.show', $project) }}" class="text-lg font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $project->title }}
                                    </a>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $project->description }}</p>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $project->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No projects found.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Recent Tasks') }}</h3>
                    <div class="space-y-4">
                        @forelse($tasks as $task)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-lg font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $task->title }}
                                    </a>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Project') }}: {{ $task->project->title }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($task->status === 'Done') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                        @elseif($task->status === 'In Progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                        {{ $task->status }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $task->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No tasks found.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 