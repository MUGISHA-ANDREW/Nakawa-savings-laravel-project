<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   public function members()
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $members = User::where('role', 'member')->get();
    
    // Additional statistics for the view
    $activeMembersCount = User::where('role', 'member')
                            ->where('account_balance', '>', 0)
                            ->count();
    
    $newMembersCount = User::where('role', 'member')
                         ->where('created_at', '>=', now()->subMonth())
                         ->count();
    
    $totalTransactions = Transaction::count();

    return view('admin.members', compact(
        'members', 
        'activeMembersCount', 
        'newMembersCount', 
        'totalTransactions'
    ));
}

    public function editMember($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $member = User::findOrFail($id);
        return view('admin.edit-member', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $member = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'phone' => 'required|unique:users,phone,' . $member->id,
            'account_balance' => 'required|numeric',
            'next_of_kin_name' => 'required|string',
            'next_of_kin_phone' => 'required|string',
            'next_of_kin_relationship' => 'required|string',
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members')->with('success', 'Member updated successfully.');
    }

    public function withdrawalRequests()
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $pendingWithdrawals = Transaction::where('type', 'withdrawal')
                                ->where('status', 'pending')
                                ->with('user')
                                ->get();

    // Additional statistics
    $approvedToday = Transaction::where('type', 'withdrawal')
                              ->where('status', 'completed')
                              ->whereDate('updated_at', today())
                              ->count();

    $eligibleRequests = $pendingWithdrawals->filter(function($withdrawal) {
        return $withdrawal->user->account_balance >= $withdrawal->amount;
    })->count();

    $problematicRequests = $pendingWithdrawals->count() - $eligibleRequests;

    $oldestRequest = $pendingWithdrawals->sortBy('created_at')->first();
    $largestRequest = $pendingWithdrawals->sortByDesc('amount')->first();

    $requestsToday = Transaction::where('type', 'withdrawal')
                              ->where('status', 'pending')
                              ->whereDate('created_at', today())
                              ->count();

    $urgentRequests = $pendingWithdrawals->filter(function($withdrawal) {
        return $withdrawal->created_at->diffInHours(now()) < 24;
    })->count();

    $recentProcessed = Transaction::where('type', 'withdrawal')
                                ->whereIn('status', ['completed', 'approved'])
                                ->with('user')
                                ->latest()
                                ->take(5)
                                ->get();

    $averageProcessingTime = "2-4 hours";
    return view('admin.withdrawals', compact(
        'pendingWithdrawals',
        'approvedToday',
        'eligibleRequests',
        'problematicRequests',
        'oldestRequest',
        'largestRequest',
        'requestsToday',
        'urgentRequests',
        'recentProcessed',
        'averageProcessingTime'
    ));
}

    public function approveWithdrawal($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $transaction = Transaction::findOrFail($id);
        $user = $transaction->user;

        if ($user->account_balance < $transaction->amount) {
            return redirect()->back()->with('error', 'Member has insufficient balance.');
        }

        // Deduct from user's balance
        $user->account_balance -= $transaction->amount;
        $user->save();

        // Update transaction status
        $transaction->status = 'completed';
        $transaction->save();

        return redirect()->back()->with('success', 'Withdrawal approved successfully.');
    }

    public function rejectWithdrawal($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'approved'; 
        $transaction->notes = 'Withdrawal rejected by admin';
        $transaction->save();

        return redirect()->back()->with('success', 'Withdrawal rejected.');
    }

    public function allTransactions()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $transactions = Transaction::with('user')->latest()->paginate(20);
        return view('admin.transactions', compact('transactions'));
    }

    public function reports()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'total_deposits' => Transaction::where('type', 'deposit')->where('status', 'completed')->sum('final_amount') ?? 0,
            'total_withdrawals' => Transaction::where('type', 'withdrawal')->where('status', 'completed')->sum('final_amount') ?? 0,
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')->where('status', 'pending')->count(),
        ];

        return view('admin.reports', compact('stats'));
    }

    public function destroyMember($id)
{
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $member = User::findOrFail($id);
    
    // Prevent deleting admin accounts
    if ($member->role === 'admin') {
        return redirect()->route('admin.members')->with('error', 'Cannot delete administrator accounts.');
    }

    // Delete related transactions first
    $member->transactions()->delete();
    
    // Then delete the member
    $member->delete();

    return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
}


public function showRegistrationForm()
{
    return view('admin.register-members');
}

public function storeMember(Request $request)
{
    // Add validation and member creation logic here
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string|max:20',
       
    ]);

    return redirect()->route('admin.members')->with('success', 'Member registered successfully!');
}
}