<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['user_id', 'rom_id', 'minutes_played', 'completed', 'played_at']; // ← rom_id

    protected $casts = ['completed' => 'boolean', 'played_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rom()
    {
        return $this->belongsTo(Rom::class);
    }
}