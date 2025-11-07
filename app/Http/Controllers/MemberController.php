<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function deposit(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isMember()) {
            return redirect('/login');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1000', // Minimum deposit 1000 UGX
        ]);

        $user = Auth::user();
        $interestRate = 1.5; // 1.5% interest per deposit
        $interestAmount = ($request->amount * $interestRate) / 100;
        $finalAmount = $request->amount + $interestAmount;

        // Create deposit transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => $request->amount, // Store the principal amount (without interest)
            'interest_rate' => $interestRate,
            'final_amount' => $finalAmount,
            'status' => 'completed', // Deposits are auto-approved
            'notes' => 'Deposit with ' . $interestRate . '% interest',
        ]);

        // Update user balance WITH interest
        $user->account_balance += $finalAmount;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Deposit of UGX ' . number_format($request->amount) . ' successful! Interest will be applied to your balance.');
    }

    public function withdraw(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isMember()) {
            return redirect('/login');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();

        // Create withdrawal request 
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $request->amount,
            'interest_rate' => 0, 
            'final_amount' => $request->amount,
            'status' => 'pending',
            'notes' => 'Withdrawal request pending admin approval',
        ]);

        return redirect()->route('dashboard')->with('success', 'Withdrawal request submitted. Waiting for admin approval.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function transactions()
    {
        if (!Auth::check() || !Auth::user()->isMember()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $transactions = $user->transactions()->latest()->paginate(10);
        
        return view('member.transactions', compact('user', 'transactions'));
    }
}