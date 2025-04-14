<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Team;
use App\Models\Project;
use App\Models\ProfitDeduction;
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

        // Hitung total gaji team yang sudah dibayar (berdasarkan amount_paid)
        $totalTeamExpenses = DB::table('project_team')
            ->join('projects', 'projects.id', '=', 'project_team.project_id')
            ->where('projects.status', '!=', 'cancel')
            ->sum('project_team.amount_paid');

        // Hitung total pengurangan profit
        $totalDeductions = ProfitDeduction::sum('amount');

        // Hitung net profit setelah pengurangan
        $netProfit = $totalIncome - $totalTeamExpenses - $totalDeductions;

        // Data lainnya yang mungkin diperlukan
        $totalTeamMembers = Team::count();
        $totalUnpaidSalary = DB::table('project_team')
            ->join('projects', 'projects.id', '=', 'project_team.project_id')
            ->where('projects.status', '!=', 'cancel')
            ->selectRaw('SUM(CASE WHEN amount_paid >= salary THEN 0 ELSE salary - COALESCE(amount_paid, 0) END) as total_unpaid')
            ->value('total_unpaid');

        return view('admin.app.dashboard', compact(
            'totalIncome',
            'totalTeamExpenses',
            'totalDeductions',
            'netProfit',
            'totalTeamMembers',
            'totalUnpaidSalary',
            'outstandingPayments'
        ));
    }
} 