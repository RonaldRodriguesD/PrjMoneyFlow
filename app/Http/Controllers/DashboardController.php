<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(){
        //informações do topo do dashboard
        $userId = auth()->id();
        $now =  Carbon::now();
    
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('value');
    
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('value');
    
        $balance = $totalIncome - $totalExpense;

        //principais ganhos e despesas

        $topExpenseCategories = Transaction::select('category_id', DB::raw('SUM(value) as total'))
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->with('category')
            ->take(3)
            ->get();

        $topIncomeSources = Transaction::where('user_id', auth()->id())
            ->where('type', 'income')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->selectRaw('`desc`, SUM(value) as total')
            ->groupBy('desc')
            ->orderByDesc('total')
            ->take(3)
            ->get();
        //informações do gráfico

        $months = collect();
        $incomeData = [];
        $expenseData = [];

        for ($i = 0; $i <= 6; $i++) {
            $date = Carbon::now()->copy()->subMonths(5 - $i);
            $label = $date->translatedFormat('M \d\e Y'); // Ex: "jun de 2025"
            $months->push(ucfirst($label));

            if ($i === -1) {
                // próximo mês (para transações recorrentes)
                $recurringIncomes = Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->where('recurrent', true)
                    ->sum('value');

                $recurringExpenses = Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->where('recurrent', true)
                    ->sum('value');

                $incomeData[] = round($recurringIncomes, 2);
                $expenseData[] = round($recurringExpenses, 2);
            } else {
                // Valores reais
                $income = Transaction::where('user_id', $userId)
                    ->where('type', 'income')
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->sum('value');

                $expense = Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->sum('value');

                $incomeData[] = round($income, 2);
                $expenseData[] = round($expense, 2);
            }
        }
    
        return view('dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'labels' => $months,
            'incomes' => $incomeData,
            'expenses' => $expenseData,
            'topExpenseCategories' => $topExpenseCategories,
            'topIncomeSources' => $topIncomeSources,
        ]);
    }
}
