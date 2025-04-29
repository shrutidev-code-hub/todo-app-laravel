@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="glass-card p-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Hey, <strong>{{ auth()->user()->name }}</strong> 👋</h2>

                <!-- Filter Buttons -->
                <div class="btn-group">
                    <a href="{{ route('index', ['filter' => 'all']) }}"
                        class="btn {{ $filter == 'all' ? 'btn-light' : 'btn-outline-secondary text-white border-white' }}">
                        <i class="fas fa-list"></i> All
                    </a>
                    <a href="{{ route('index', ['filter' => 'pending']) }}"
                        class="btn {{ $filter == 'all' ? 'btn-light' : 'btn-outline-secondary text-white border-white' }}">
                        <i class="fas fa-hourglass-half"></i> Pending
                    </a>
                    <a href="{{ route('index', ['filter' => 'completed']) }}"
                       class="btn {{ $filter == 'completed' ? 'btn-light' : 'btn-outline-light' }}">
                       <i class="fas fa-check"></i> Completed
                    </a>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="alert alert-info">
                <strong>Total Tasks: </strong> {{ $totalTasks }}
            </div>


            <!-- Add Task Form -->
            <form method="POST" action="{{ route('store') }}" class="mb-4">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <input type="text" name="title" class="form-control" placeholder="What needs to be done?" required>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Add Task
                        </button>
                    </div>
                </div>
            </form>

            <!-- Edit Task Modal -->
            <div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                <form method="POST" id="editTaskForm" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <input type="text" name="title" class="form-control mb-3" id="editTaskTitle" required>
                    <input type="date" name="due_date" class="form-control" id="editTaskDate">
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                </div>
            </div>
            

            <!-- Task List -->
            <div id="taskList">
                @forelse ($tasks as $task)
                    <div class="task-item animate__animated animate__fadeInUp" id="task-{{ $task->id }}">
                        <span class="{{ $task->is_completed ? 'text-decoration-line-through text-light opacity-50' : '' }}">
                            {{ $task->title }}

                            @if ($task->due_date)
                                <small class="text-light ms-2">
                                    <i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                </small>
                            @endif
                        </span>

                        <div class="d-flex gap-2">
                            @if (!$task->is_completed)
                                <form method="POST" action="{{ route('complete', $task->id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                </form>
                            @endif

                            <button class="btn btn-warning btn-sm" onclick="openEditModal('{{ route('update', $task->id) }}', '{{ $task->title }}', '{{ $task->due_date }}')">✏️</button>

                            <form method="POST" action="{{ route('destroy', $task->id) }}" onsubmit="return fadeOutTask(this, {{ $task->id }})">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-light text-center mt-4">No tasks yet. Let’s get productive! ✨</p>
                @endforelse
            </div>


        </div>
    </div>
</div>
@endsection
<script>
    function openEditModal(action, title, date) {
        document.getElementById('editTaskForm').action = action;
        document.getElementById('editTaskTitle').value = title;
        document.getElementById('editTaskDate').value = date;

        var modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
        modal.show();
    }
</script>
<script>
    function fadeOutTask(form, taskId) {
        event.preventDefault();
        const taskDiv = document.getElementById('task-' + taskId);
        taskDiv.classList.add('animate__fadeOutLeft');
    
        setTimeout(() => {
            form.submit();
        }, 500);
    
        return false;
    }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Sortable(taskList, {
                animation: 200,
                onEnd: function () {
                    let order = [];
                    document.querySelectorAll('#taskList .task-item').forEach(item => {
                        order.push(item.id.replace('task-', ''));
                    });
        
                    fetch("{{ route('reorder') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });
        });
        </script>
        
    