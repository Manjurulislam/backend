<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
      return  $query->where('status', 1)->orderBy('title', 'asc');
    }
}
