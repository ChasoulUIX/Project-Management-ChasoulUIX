<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Project $project)
    {
        return view('admin.payments.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $project->payments()->create($validated);

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Payment recorded successfully.');
    }

    public function destroy(Project $project, Payment $payment)
    {
        $payment->delete();
        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Payment deleted successfully.');
    }
} 