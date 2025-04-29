<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $totalTasks = Task::where('user_id', auth()->id())->count();
        $filter = $request->get('filter', 'all');
        $query = Task::where('user_id', auth()->id());
    
        if ($filter === 'completed') {
            $query->where('is_completed', true);
        } elseif ($filter === 'pending') {
            $query->where('is_completed', false);
        }
    
        $tasks = $query->latest()->get();
        return view('index', compact('tasks', 'filter', 'totalTasks'));
    }
    
    

    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $task->user_id = auth()->id();
        $task->save();
    
        return redirect()->back()->with('success', 'Task added successfully!');
    }
    
    public function complete(Task $task)
    {
        $task->is_completed = true;
        $task->save();
    
        return redirect()->back()->with('success', 'Task marked as complete!');
    }
    
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    public function update(Request $request, Task $task)
{
    $task->title = $request->title;
    $task->due_date = $request->due_date;
    $task->save();

    return redirect()->back()->with('success', 'Task updated!');
}
public function reorder(Request $request)
{
    foreach ($request->order as $index => $taskId) {
        Task::where('id', $taskId)->where('user_id', auth()->id())
            ->update(['order' => $index]);
    }

    return response()->json(['success' => true]);
}

public function dashboard()
{
    $totalTasks = Task::where('user_id', auth()->id())->count();
    $completedTasks = Task::where('user_id', auth()->id())->where('is_completed', true)->count();
    $pendingTasks = Task::where('user_id', auth()->id())->where('is_completed', false)->count();

    return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks'));
}

    
}
