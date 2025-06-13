<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BudgetController extends Controller
{
    private function getAvailableMonths()
    {
        $months = [];
        $startMonth = Carbon::now()->subMonths(6);
        $endMonth = Carbon::now()->addMonths(6);

        $period = CarbonPeriod::create($startMonth, '1 month', $endMonth);

        foreach ($period as $date) {
            $monthYear = $date->format('Y-m');
            $monthName = $date->isoFormat('MMMM [de] YYYY');
            $months[$monthYear] = ucfirst($monthName);
        }
        return $months;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $availableMonths = $this->getAvailableMonths();
        $selectedMonthYear = request('month_year', now()->format('Y-m'));

        list($year, $month) = explode('-', $selectedMonthYear);

        $budgets = Budget::with('category')
            ->where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $totalBudgetAmount = $budgets->sum('limit');

        $currentSpendAmount = Transaction::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('type', 'expense')
            ->sum('value');

        $exceededCategoriesCount = 0;
        $exceededCategoriesNames = [];
        foreach ($budgets as $budget) {
            $categorySpend = Transaction::where('user_id', auth()->id())
                ->where('category_id', $budget->category_id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('type', 'expense')
                ->sum('value');

            if ($categorySpend > $budget->limit) {
                $exceededCategoriesCount++;
                $exceededCategoriesNames[] = $budget->category->desc;
            }
        }

        $categories = Category::all();

        return view('budgets', [
            'categories' => $categories,
            'budgets' => $budgets,
            'availableMonths' => $availableMonths,
            'selectedMonthYear' => $selectedMonthYear,
            'totalBudgetAmount' => $totalBudgetAmount,
            'currentSpendAmount' => $currentSpendAmount,
            'exceededCategoriesCount' => $exceededCategoriesCount,
            'exceededCategoriesNames' => $exceededCategoriesNames
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableMonths = $this->getAvailableMonths();
        $selectedMonthYear = request('month_year', now()->format('Y-m'));

        list($year, $month) = explode('-', $selectedMonthYear);

        $categories = Category::all();
        $budgets = Budget::with('category')
            ->where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $totalBudgetAmount = $budgets->sum('limit');

        $currentSpendAmount = Transaction::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('type', 'expense')
            ->sum('value');

        $exceededCategoriesCount = 0;
        $exceededCategoriesNames = [];
        foreach ($budgets as $budget) {
            $categorySpend = Transaction::where('user_id', auth()->id())
                ->where('category_id', $budget->category_id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('type', 'expense')
                ->sum('value');

            if ($categorySpend > $budget->limit) {
                $exceededCategoriesCount++;
                $exceededCategoriesNames[] = $budget->category->desc;
            }
        }

        return view('budgets', [
            'categories' => $categories,
            'budgets' => $budgets,
            'availableMonths' => $availableMonths,
            'selectedMonthYear' => $selectedMonthYear,
            'totalBudgetAmount' => $totalBudgetAmount,
            'currentSpendAmount' => $currentSpendAmount,
            'exceededCategoriesCount' => $exceededCategoriesCount,
            'exceededCategoriesNames' => $exceededCategoriesNames
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
        $budget->date = Carbon::parse($validated['month']);
        $budget->user_id = auth()->id();
        $budget->created_at = Carbon::parse($validated['month']);
        $budget->save();

        return redirect()->route('budgets.index')->with('success', 'Orçamento definido com sucesso!');
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
        return redirect()->route('budgets.index')->with('success', 'Orçamento excluído com sucesso!');
    }
}
