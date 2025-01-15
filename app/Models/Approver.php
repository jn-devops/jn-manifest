<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    protected $fillable = [
        'approver_type', // Approver 1 or Approver 2
        'name',
        'email',
        'unit',
        'type',
        'department',
        'cost_center',
        'budget_line_charging_1',
        'gl_account',
        'budget_line_charging_2',
        'product',
    ];
}
