<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'content',
        'scope'
    ];

    protected $hidden = [
        'scope'
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'target_id', 'id');
    }
}
