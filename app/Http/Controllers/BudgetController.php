<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentMonth = request('month', now()->format('m'));
        $currentYear = request('year', now()->format('Y'));

        $budgets = Budget::with('category')
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        $categories = Category::all();

        return view('budgets', [
            'categories' => $categories,
            'budgets' => $budgets,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $currentMonth = request('month', now()->format('m'));
        $currentYear = request('year', now()->format('Y'));

        $budgets = Budget::with('category')
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        return view('budgets', [
            'categories' => $categories,
            'budgets' => $budgets,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|exists:categories,id',
            'limit' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
            'notes' => 'nullable|string|max:255'
        ]);

        // Verifica se já existe um orçamento para esta categoria no mês selecionado
        $existingBudget = Budget::where('user_id', auth()->id())
            ->where('category_id', $validated['category'])
            ->whereMonth('created_at', Carbon::parse($validated['month'])->month)
            ->whereYear('created_at', Carbon::parse($validated['month'])->year)
            ->first();

        if ($existingBudget) {
            return redirect()->back()->with('error', 'Já existe um orçamento definido para esta categoria neste mês.');
        }

        $budget = new Budget();
        $budget->category_id = $validated['category'];
        $budget->limit = $validated['limit'];
        $budget->obs = $validated['notes'] ?? '';
        $budget->user_id = auth()->id();
        $budget->created_at = Carbon::parse($validated['month']);
        $budget->save();

        return redirect()->route('budgets')->with('success', 'Orçamento definido com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir este orçamento.');
        }

        $budget->delete();
        return redirect()->route('budgets')->with('success', 'Orçamento excluído com sucesso!');
    }
}
