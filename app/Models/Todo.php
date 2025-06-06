<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'user_id',
        'is_complete',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

}
