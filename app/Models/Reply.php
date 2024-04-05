<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Message;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    public $timestamps = false;

    public function message(): HasOne
    {
        return $this->hasOne(Message::class, 'id', 'source_id');
    }

    // public function creator(): HasOne
    // {
    //     return $this->hasOne(User::class, 'id', 'source_id');
    // }
}
