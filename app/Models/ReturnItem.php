<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'loan_id',
        'item_id',
        'return_date',
        'conditional',
        'penalty',
        'note',

    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
