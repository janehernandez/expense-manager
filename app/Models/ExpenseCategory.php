<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function usersExpenses()
    {
        return $this->hasMany(UsersExpense::class, 'expense_category_id');
    }
}
