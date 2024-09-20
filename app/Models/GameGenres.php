<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameGenres extends Model
{
    use HasFactory;

    protected $table="gameGenres";
    protected $fillable=["gameId","genre"];


    public function Games(): BelongsTo{
        return $this->belongsTo(Games::class);
    }
}
