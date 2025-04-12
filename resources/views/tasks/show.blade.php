<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Project</p>
                            <p class="font-medium">{{ $task->project->title }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium">{{ $task->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="font-medium">{{ $task->due_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Priority</p>
                            <p class="font-medium">{{ $task->priority }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Edit Task
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                Delete Task
                            </button>
                        </form>
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            Back to Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 