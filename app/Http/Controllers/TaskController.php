<?php


namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->with('tasks')->get(); // Récupérer les projets avec leurs tâches
        return view('tasks.index', compact('projects'));
    }

    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date|after:today',
            'project_id' => 'required|exists:projects,id', // Validation du projet associé
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function complete($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->is_completed = true;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task marked as completed.');
    }

    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
