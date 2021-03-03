<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

 /*   public function getImageAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }*/

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('title', 'asc');
    }
}
