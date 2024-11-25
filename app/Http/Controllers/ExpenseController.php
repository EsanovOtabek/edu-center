<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $paymentMethods = ['cash', 'cashusd', 'bank', 'transfer'];

        // Filter by payment method if provided
        $expenses = Expense::query();

        if ($request->has('payment_method') && $request->payment_method != 'all') {
            $expenses = $expenses->where('payment_method', $request->payment_method);
        }

        $expenses = $expenses->get();

        return view('dashboard.expenses.index', compact('expenses', 'paymentMethods'));
    }

    public function create()
    {
        // For the form to create a new expense
        return view('dashboard.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,cashusd,bank,transfer',
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'currency' => $request->currency ?? 'UZS',
            'payment_method' => $request->payment_method,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success_msg', 'Xarajat muvaffaqiyatli qo\'shildi');
    }


}
