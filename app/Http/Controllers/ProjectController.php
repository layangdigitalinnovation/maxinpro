<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => ['nullable', 'in:Launching,Premium,New Cluster,Sold Out'],
        ]);

        $query = Project::query()->with(['developer', 'area', 'propertyType'])->published();

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $projects = $query->orderByPriority()->paginate(9)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['developer', 'area', 'images']);

        return view('projects.show', compact('project'));
    }
}
