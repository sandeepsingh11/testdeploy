<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['special', 'sub'];

    public function special()
    {
        return $this->belongsTo(Special::class);
    }

    public function sub()
    {
        return $this->belongsTo(Sub::class);
    }
}
