<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden   = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('title', 'asc');
    }
}
