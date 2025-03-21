<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total nilai project (price) kecuali yang cancel
        $totalProjectValue = Project::where('status', '!=', 'cancel')->sum('price');
        
        // Hitung total pembayaran yang sudah diterima
        $totalPayments = Payment::whereHas('project', function($query) {
            $query->where('status', '!=', 'cancel');
        })->sum('amount');
        
        // Hitung sisa pembayaran yang belum diterima (hanya untuk project aktif)
        $outstandingPayments = $totalProjectValue - $totalPayments;

        // Hitung total income (tidak termasuk project yang cancel)
        $totalIncome = $totalPayments;

        // Hitung total gaji team yang sudah dibayar
        $totalTeamExpenses = DB::table('project_team')
            ->join('projects', 'projects.id', '=', 'project_team.project_id')
            ->where('project_team.status', 'paid')
            ->where('projects.status', '!=', 'cancel')
            ->sum('project_team.salary');

        // Hitung net profit
        $netProfit = $totalIncome - $totalTeamExpenses;

        // Data lainnya yang mungkin diperlukan
        $totalTeamMembers = Team::count();
        $totalUnpaidSalary = DB::table('project_team')
            ->where('status', 'unpaid')
            ->sum('salary');

        return view('admin.app.dashboard', compact(
            'totalIncome',
            'totalTeamExpenses',
            'netProfit',
            'totalTeamMembers',
            'totalUnpaidSalary',
            'outstandingPayments'
        ));
    }
} 