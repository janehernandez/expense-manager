<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $userId = auth()->id();

        // get the summary of the expenses
        $summary = DB::table('users_expenses')
            ->selectRaw('expense_categories.name as category, SUM(amount) AS total_amount')
            ->selectRaw("(SUM(amount) / (SELECT SUM(amount) FROM users_expenses WHERE user_id = $userId)) * 100 AS percentage")
            ->where('user_id', auth()->id())
            ->join('expense_categories', 'expense_categories.id', '=', 'users_expenses.expense_category_id')
            ->groupBy('expense_category_id')
            ->get();

        $categories = $summary->pluck('category')->toArray();
        $percentages = $summary->pluck('percentage')->map(function ($percentage) {
            return floatval($percentage);
        })->toArray();

        return Inertia::render('Dashboard', compact('summary', 'categories', 'percentages'));
    }
}
