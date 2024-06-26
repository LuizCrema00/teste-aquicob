<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'entrada', 'saida',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
