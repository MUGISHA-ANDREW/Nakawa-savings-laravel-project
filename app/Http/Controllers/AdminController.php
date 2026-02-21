<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

/** @var \App\Models\User $user */
class AdminController extends Controller
{
   public function members()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if (!$user || !$user->isAdmin()) {
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $member = User::findOrFail($id);
        return view('admin.edit-member', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
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
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if (!$user || !$user->isAdmin()) {
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
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        if (!$authUser || !$authUser->isAdmin()) {
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $transactions = Transaction::with('user')->latest()->paginate(20);
        return view('admin.transactions', compact('transactions'));
    }

    public function reports()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
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
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if (!$user || !$user->isAdmin()) {
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
    /** @var \App\Models\User $authUser */
    $authUser = Auth::user();
    if (!$authUser || !$authUser->isAdmin()) {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20|unique:users,phone',
        'username' => 'required|string|max:255|unique:users,username',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:member,admin,treasurer',
        'next_of_kin_name' => 'required|string|max:255',
        'next_of_kin_phone' => 'required|string|max:20',
        'next_of_kin_relationship' => 'required|string|max:255',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'username' => $validated['username'],
        'password' => Hash::make($validated['password']),
        'next_of_kin_name' => $validated['next_of_kin_name'],
        'next_of_kin_phone' => $validated['next_of_kin_phone'],
        'next_of_kin_relationship' => $validated['next_of_kin_relationship'],
        'role' => $validated['role'],
        'account_balance' => 0,
    ]);

    return redirect()->route('admin.members')->with('success', 'Member registered successfully!');
}

public function exportMembers(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if (!$user || !$user->isAdmin()) {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $format = $request->input('format', 'csv');
    $includeBalances = $request->has('include_balances');
    $includeTransactions = $request->has('include_transactions');

    $members = User::where('role', 'member')->get();

    if ($format === 'pdf') {
        return $this->exportMembersPdf($members, $includeBalances, $includeTransactions);
    }

    $filename = 'nmsg_members_' . date('Y-m-d_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($members, $includeBalances, $includeTransactions) {
        $file = fopen('php://output', 'w');

        // Header row
        $headerRow = ['#', 'Name', 'Email', 'Phone', 'Username', 'Next of Kin', 'Kin Relationship', 'Kin Phone', 'Joined Date'];
        if ($includeBalances) {
            $headerRow[] = 'Account Balance (UGX)';
        }
        if ($includeTransactions) {
            $headerRow[] = 'Total Deposits (UGX)';
            $headerRow[] = 'Total Withdrawals (UGX)';
        }
        fputcsv($file, $headerRow);

        // Data rows
        foreach ($members as $index => $member) {
            $row = [
                $index + 1,
                $member->name,
                $member->email,
                $member->phone,
                $member->username,
                $member->next_of_kin_name ?? 'N/A',
                $member->next_of_kin_relationship ?? 'N/A',
                $member->next_of_kin_phone ?? 'N/A',
                $member->created_at->format('M d, Y'),
            ];
            if ($includeBalances) {
                $row[] = number_format($member->account_balance, 2);
            }
            if ($includeTransactions) {
                $totalDeposits = $member->transactions()->where('type', 'deposit')->where('status', 'completed')->sum('final_amount');
                $totalWithdrawals = $member->transactions()->where('type', 'withdrawal')->where('status', 'completed')->sum('final_amount');
                $row[] = number_format($totalDeposits, 2);
                $row[] = number_format($totalWithdrawals, 2);
            }
            fputcsv($file, $row);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

private function exportMembersPdf($members, $includeBalances, $includeTransactions)
{
    $data = [];
    foreach ($members as $index => $member) {
        $row = [
            'num' => $index + 1,
            'name' => $member->name,
            'email' => $member->email,
            'phone' => $member->phone,
            'username' => $member->username,
            'next_of_kin_name' => $member->next_of_kin_name ?? 'N/A',
            'next_of_kin_relationship' => $member->next_of_kin_relationship ?? 'N/A',
            'next_of_kin_phone' => $member->next_of_kin_phone ?? 'N/A',
            'joined' => $member->created_at->format('M d, Y'),
        ];
        if ($includeBalances) {
            $row['balance'] = number_format($member->account_balance, 2);
        }
        if ($includeTransactions) {
            $row['deposits'] = number_format(
                $member->transactions()->where('type', 'deposit')->where('status', 'completed')->sum('final_amount'), 2
            );
            $row['withdrawals'] = number_format(
                $member->transactions()->where('type', 'withdrawal')->where('status', 'completed')->sum('final_amount'), 2
            );
        }
        $data[] = $row;
    }

    $pdf = Pdf::loadView('admin.exports.members-pdf', [
        'members' => $data,
        'includeBalances' => $includeBalances,
        'includeTransactions' => $includeTransactions,
        'generatedAt' => now()->format('F d, Y \a\t h:i A'),
    ])->setPaper('a4', 'landscape');

    return $pdf->download('nmsg_members_' . date('Y-m-d_His') . '.pdf');
}
}