<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'soft_cap',
        'eshop_id',
        'ignored',
        'url'
    ];

    public function scopeFilters($query, $filters)
    {
        if (isset($filters['price'])) {
            $query->where('price', 'like', '%' . $filters['price'] . '%');
        }
        if (isset($filters['soft_cap'])) {
            $query->where('soft_cap', 'like', '%' . $filters['soft_cap'] . '%');
        }
        if (isset($filters['ignored'])) {
            $query->where('ignored', 'like', '%' . $filters['ignored'] . '%');
        }
        if (isset($filters['url'])) {
            $query->where('url', 'like', '%' . $filters['url'] . '%');
        }
        return $query;
    }

}
