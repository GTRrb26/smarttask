<div class="p-4">
    <div class="grid grid-cols-3 gap-4">
        @foreach($statuses as $status)
            <div class="bg-gray-100 p-4 rounded-lg"
                 x-data="{ dropTarget: false }"
                 x-on:dragover.prevent="dropTarget = true"
                 x-on:dragleave.prevent="dropTarget = false"
                 x-on:drop.prevent="
                    dropTarget = false;
                    const taskId = event.dataTransfer.getData('text/plain');
                    const order = {{ $tasks[$status] ?? collect() }}
                        .filter(t => t.id != taskId)
                        .length;
                    $wire.updateTaskStatus(taskId, '{{ $status }}', order);
                 "
                 :class="{ 'bg-gray-200': dropTarget }">
                <h3 class="font-semibold mb-4">{{ $status }}</h3>
                <div class="space-y-2">
                    @foreach($tasks[$status] ?? [] as $task)
                        <div class="bg-white p-3 rounded shadow cursor-move"
                             draggable="true"
                             x-on:dragstart="event.dataTransfer.setData('text/plain', {{ $task->id }})">
                            <h4 class="font-medium">{{ $task->title }}</h4>
                            <p class="text-sm text-gray-600 truncate">{{ $task->description }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs text-gray-500">Due: {{ $task->due_date->format('M d, Y') }}</span>
                                @if($task->assignedTo)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        {{ $task->assignedTo->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('tasksUpdated', () => {
            // Refresh the tasks when they're updated
            window.location.reload();
        });
    });
</script>
@endpush
