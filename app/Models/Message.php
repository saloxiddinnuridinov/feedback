<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'telegram_user_id',
        'telegram_message_id',
        'message',
        'type',
        'created_at',
        'updated_at'
    ];

    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class, 'telegram_user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'message_id');
    }

}
