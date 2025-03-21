<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('projects')->latest()->paginate(9);
        $totalPaidSalary = DB::table('project_team')->where('status', 'paid')->sum('salary');
        $totalUnpaidSalary = DB::table('project_team')->where('status', 'unpaid')->sum('salary');

        return view('admin.teams.index', compact('teams', 'totalPaidSalary', 'totalUnpaidSalary'));
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
            'notes' => 'nullable|string'
        ]);

        // Hapus karakter non-numerik dari whatsapp
        $whatsapp = preg_replace('/[^0-9]/', '', $validated['whatsapp']);

        // Buat team baru
        $team = Team::create([
            'name' => $validated['name'],
            'whatsapp' => $whatsapp
        ]);

        // Attach ke project dengan data pivot
        $team->projects()->attach($validated['project_id'], [
            'salary' => $validated['salary'],
            'status' => 'unpaid',
            'notes' => $validated['notes'] ?? null
        ]);

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member added successfully.');
    }

    public function edit(Team $team)
    {
        $projects = Project::all();
        $currentProject = $team->projects->first();
        return view('admin.teams.edit', compact('team', 'projects', 'currentProject'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'project_id' => 'required|exists:projects,id',
            'salary' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // Hapus karakter non-numerik dari whatsapp
        $whatsapp = preg_replace('/[^0-9]/', '', $validated['whatsapp']);

        $team->update([
            'name' => $validated['name'],
            'whatsapp' => $whatsapp
        ]);

        // Sync project dengan data pivot baru
        $team->projects()->sync([
            $validated['project_id'] => [
                'salary' => $validated['salary'],
                'notes' => $validated['notes'] ?? null
            ]
        ]);

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(Team $team)
    {
        // Ini akan otomatis menghapus record di pivot table
        $team->delete();

        return redirect()
            ->route('admin.teams.index')
            ->with('success', 'Team member deleted successfully.');
    }

    public function show(Team $team)
    {
        $team->load('projects');
        
        // Hitung total salary
        $totalSalary = $team->projects->sum('pivot.salary');
        $totalPaidSalary = $team->projects->where('pivot.status', 'paid')->sum('pivot.salary');
        $totalUnpaidSalary = $team->projects->where('pivot.status', 'unpaid')->sum('pivot.salary');

        // Ambil project yang belum ditambahkan ke team
        $availableProjects = Project::whereNotIn('id', $team->projects->pluck('id'))->get();

        return view('admin.teams.show', compact(
            'team', 
            'totalSalary', 
            'totalPaidSalary', 
            'totalUnpaidSalary',
            'availableProjects'
        ));
    }

    public function addProject(Request $request, Team $team)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'salary' => 'required|numeric|min:0',
        ]);

        // Cek apakah project sudah ada
        if ($team->projects->contains($validated['project_id'])) {
            return back()->with('error', 'Project already assigned to this team member.');
        }

        // Tambahkan project baru
        $team->projects()->attach($validated['project_id'], [
            'salary' => $validated['salary'],
            'status' => 'unpaid'
        ]);

        return back()->with('success', 'Project added successfully.');
    }

    public function updatePaymentStatus(Request $request, Team $team, Project $project)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
            'payment_date' => 'required_if:status,paid|nullable|date'
        ]);

        $team->projects()->updateExistingPivot($project->id, [
            'status' => $validated['status'],
            'payment_date' => $validated['status'] === 'paid' ? $validated['payment_date'] : null
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }

    public function markProjectAsPaid(Team $team, Project $project)
    {
        // Validasi bahwa project memang terkait dengan team ini
        if (!$team->projects->contains($project->id)) {
            return back()->with('error', 'Project not found for this team member.');
        }

        // Update status project menjadi paid
        $team->projects()->updateExistingPivot($project->id, [
            'status' => 'paid',
            'payment_date' => now()
        ]);

        return back()->with('success', 'Project has been marked as paid.');
    }
} 