<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    
     public function index()
     {
        $types = Type::latest()->get();
        $tasks = Task::with(['types'])->orderBy('created_at','desc')->get();
        return Inertia::render('Task/Index', ['tasks' => $tasks, 'types' => $types]);
    }

    public function history()
     {
        $types = Type::latest()->get();
        $history = History::latest()->get();
        $tasks = Task::with(['types'])->orderBy('created_at','desc')->get();
        return Inertia::render('Task/Index', ['tasks' => $tasks, 'types' => $types, 'history' => $history]);
    }
     public function dashboard()
     {
        $type = Type::latest()->get();
        $task = Task::with(['types'])->latest()->get();
        return Inertia::render('Task/Dashboard', ['task' => $task, 'type' => $type]);
    } 
    public function pending(){
        $task = Task::with(['types'])->get();
        return Inertia::render('Task/Pending', ['task' => $task]);
    }

     public function completed(){
        $task = Task::with(['types'])->get();
        return Inertia::render('Task/Completed', ['task' => $task]);
    }

    public function create()
    {   
        $type = Type::latest()->get();
        return Inertia::render('Task/Create', ['type' => $type]);
    }

    public function store()
    {
        $data = request()->validate([
            'task' => ['required', 'string'],
            'due' => ['required', 'date'],
            'type_ids' => ['required', 'array'],
            'type_ids.*' => ['required', 'integer']
        ]);

        
        $types = $data['type_ids'];
        unset($data['type_ids']);
        $task = Task::create($data);
        $task->types()->attach($types);
        return to_route('task.index');
    }

    public function edit(Task $task)
    {
        $type = Type::latest()->get();
        $task->loadMissing('types');
        return Inertia:: render('Task/Edit', ['task' => $task,'type' => $type]);
    }
    public function update(Task $task){

         $data = request()->validate([
            'task' => ['required', 'string'],
            'due' => ['required', 'date'],
            'type_ids' => ['required', 'array'],
            'type_ids.*' => ['required', 'integer']
        ]);

        $types = $data['type_ids'];
        unset($data['type_ids']);
        $task->types()->sync($types);
        $task->update($data);
        return to_route('task.index');
    }

    public function destroy(Task $task) {
        $task->delete();
        return to_route('task.index');
    }

    public function updateStatus(Request $request, $id){
        $task = Task::findOrFail($id);
        $task->update([
            'status' => $request->status
        ]);
        return back();
    }


}
