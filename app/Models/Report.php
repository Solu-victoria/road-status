<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */ 
    protected $fillable = [
        'user_id',
        'city',
        'state',
        'address',
        'road_rating',
        'description',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
