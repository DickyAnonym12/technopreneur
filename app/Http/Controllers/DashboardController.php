<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\TambahMinuman;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMitra = Mitra::count();
        $totalUser = User::count();
        $totalMinuman = TambahMinuman::count();
        
        // Fetch recent customers
        $pelangganTerbaru = DB::table('pelanggan')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get(['first_name', 'email', 'created_at']);
        
            $recentActivities = DB::table('activities')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(['description', 'created_at']);
            
        return view('admin.dashboard', compact('totalMitra', 'totalUser', 'totalMinuman', 'pelangganTerbaru', 'recentActivities'));
    }
}