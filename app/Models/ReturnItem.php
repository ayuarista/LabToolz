<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'loan_item_id',
        'return_date',
        'conditional',
        'penalty',
        'note',

    ];

    public function loanItem()
    {
        return $this->belongsTo(LoanItem::class);
    }
}
