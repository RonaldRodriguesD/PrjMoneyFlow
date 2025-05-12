<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transactions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('transactions', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required|exists:categories,id',
            'transactionType' => 'required|in:income,expense',
            'recurrent' => 'nullable|boolean',
        ]);

        $transaction = new Transaction;
        $transaction->desc = $validated['description'];
        $transaction->value = $validated['amount'];
        $transaction->date = $validated['date'];
        $transaction->category_id = $validated['category'];
        $transaction->type = $validated['transactionType'];
        $transaction->recurrent = $request->has('recurrent');
        $transaction->user_id = auth()->id();
        $transaction->save();

        if ($transaction->recurrent) {
            $originalDate = \Carbon\Carbon::parse($validated['date']);
    
            for ($i = 1; $i < 12; $i++) {
                $newDate = $originalDate->copy()->addMonths($i);
    
                // Criação da transação mensal
                Transaction::create([
                    'desc' => $validated['description'],
                    'value' => $validated['amount'],
                    'date' => $newDate->format('Y-m-d'),
                    'category_id' => $validated['category'],
                    'type' => $validated['transactionType'],
                    'recurrent' => true,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('transactions.create')->with([
            'success' => 'Transação registrada com sucesso!',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
