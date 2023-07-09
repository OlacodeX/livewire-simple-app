<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
