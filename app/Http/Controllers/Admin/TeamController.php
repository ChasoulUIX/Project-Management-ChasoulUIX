<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('project')->latest()->paginate(10);
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('admin.teams.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'project_id' => 'required|exists:projects,id',
            'salary' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'unpaid';

        $team = Team::create($validated);

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member added successfully.');
    }

    public function edit(Team $team)
    {
        $projects = Project::all();
        return view('admin.teams.edit', compact('team', 'projects'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string',
        ]);

        $team->update($validated);

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function markAsPaid(Team $team)
    {
        $team->update([
            'status' => 'paid',
            'payment_date' => now()
        ]);

        return redirect()
            ->back()
            ->with('success', 'Payment marked as paid successfully.');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member deleted successfully.');
    }
} 