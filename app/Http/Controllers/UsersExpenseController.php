<?php

namespace App\Http\Controllers;

use App\Models\UsersExpense;
use App\Http\Requests\StoreUsersExpenseRequest;
use App\Http\Requests\UpdateUsersExpenseRequest;
use App\Models\ExpenseCategory;
use Inertia\Inertia;

class UsersExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::all();
        $userExpenses = UsersExpense::with(['expenseCategory:name,id'])->whereUserId(auth()->id())->get();
        return Inertia::render('ExpenseManagement/Index', compact('userExpenses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersExpenseRequest $request)
    {
        UsersExpense::create([
            'user_id' => auth()->id(),
            ...$request->validated()
        ]);

        return back()->with(['message' => 'success|Expense has been created.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersExpenseRequest $request, UsersExpense $expense)
    {
        $expense->update($request->validated());
        return back()->with('message', 'success|Expense has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UsersExpense $expense)
    {
        $expense->delete();
        return back()->with('message', 'success|Expense has been deleted.');
    }
}
