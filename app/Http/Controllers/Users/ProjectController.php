<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function check()
    {
        return view('users.projects.check');
    }

    public function search(Request $request)
    {
        $whatsapp = preg_replace('/[^0-9]/', '', $request->whatsapp);
        
        $client = Client::where('whatsapp', $whatsapp)
            ->with(['projects' => function($query) {
                $query->with('payments')->latest();
            }])
            ->first();

        if (!$client) {
            return back()->with('error', 'No records found for this number.');
        }

        return view('users.projects.history', compact('client'));
    }
} 