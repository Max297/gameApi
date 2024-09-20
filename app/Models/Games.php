<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    protected $table="games";
    protected $fillable=["gameName","gameDev"];


    public function gameGenres(): HasMany{
        return $this->hasMAny(gameGenres::class);
    }
}
