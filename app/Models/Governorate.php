<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reels() {
        return $this->hasMany(Reel::class);
    }

}
