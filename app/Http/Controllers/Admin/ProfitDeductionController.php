<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfitDeduction;
use Illuminate\Http\Request;

class ProfitDeductionController extends Controller
{
    public function index()
    {
        $deductions = ProfitDeduction::latest()->paginate(10);
        $totalDeductions = ProfitDeduction::sum('amount');
        return view('admin.profit-deductions.index', compact('deductions', 'totalDeductions'));
    }

    public function create()
    {
        return view('admin.profit-deductions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'deduction_date' => 'required|date'
        ]);

        ProfitDeduction::create($validated);

        return redirect()->route('admin.profit-deductions.index')
            ->with('success', 'Profit deduction created successfully.');
    }

    public function edit(ProfitDeduction $profitDeduction)
    {
        return view('admin.profit-deductions.edit', compact('profitDeduction'));
    }

    public function update(Request $request, ProfitDeduction $profitDeduction)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'deduction_date' => 'required|date'
        ]);

        $profitDeduction->update($validated);

        return redirect()->route('admin.profit-deductions.index')
            ->with('success', 'Profit deduction updated successfully.');
    }

    public function destroy(ProfitDeduction $deduction)
    {
        $deduction->delete();

        return redirect()->route('admin.profit-deductions.index')
            ->with('success', 'Profit deduction deleted successfully.');
    }
} 