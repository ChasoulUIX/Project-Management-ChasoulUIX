<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(20);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::all();
        $statuses = [
            'pending' => 'Pending',
            'process' => 'In Progress',
            'success' => 'Completed',
            'cancel' => 'Cancelled'
        ];
        
        return view('admin.projects.create', compact('clients', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,process,cancel,success',
        ]);

        $project = Project::create($validated);

        $client = Client::find($validated['client_id']);
        $client->updateLastProject();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $clients = Client::all();
        $statuses = [
            'pending' => 'Pending',
            'process' => 'In Progress',
            'success' => 'Completed',
            'cancel' => 'Cancelled'
        ];
        
        return view('admin.projects.edit', compact('project', 'clients', 'statuses'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,process,cancel,success',
        ]);

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function show(Project $project)
    {
        $payments = $project->payments()->latest()->get();
        return view('admin.projects.show', compact('project', 'payments'));
    }
} 