<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'stock',
        'image',
        'slug'
    ];

    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
