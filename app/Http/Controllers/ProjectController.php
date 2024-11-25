<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    // Méthode pour afficher un projet spécifique avec ses tâches
    public function show($id)
    {
        // Récupérer le projet avec ses tâches
        $project = Project::with('tasks')->findOrFail($id);

        // Vérifier que l'utilisateur connecté est bien le propriétaire du projet
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Retourner la vue pour afficher le projet et ses tâches
        return view('projects.show', compact('project'));
    }

    // Vous pouvez ajouter d'autres méthodes pour modifier ou supprimer des projets si nécessaire
}
