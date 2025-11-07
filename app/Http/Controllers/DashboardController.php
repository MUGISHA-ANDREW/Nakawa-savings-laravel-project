<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->memberDashboard();
    }
    
    private function adminDashboard()
    {
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'total_balance' => User::where('role', 'member')->sum('account_balance'),
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')
                                                ->where('status', 'pending')
                                                ->count(),
            'total_transactions' => Transaction::count(),
        ];
        
        $recentTransactions = Transaction::with('user')
                                        ->latest()
                                        ->take(10)
                                        ->get();
        
        $members = User::where('role', 'member')->get();
        
        return view('admin.dashboard', compact('stats', 'recentTransactions', 'members'));
    }
    
    private function memberDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_deposits' => $user->deposits()->where('status', 'completed')->sum('final_amount') ?? 0,
            'total_withdrawals' => $user->withdrawals()->where('status', 'completed')->sum('final_amount') ?? 0,
            'pending_requests' => $user->transactions()->where('status', 'pending')->count(),
        ];

        $transactions = $user->transactions()
                            ->latest()
                            ->take(10)
                            ->get();
        
        return view('member.dashboard', compact('user', 'transactions', 'stats'));
    }
}