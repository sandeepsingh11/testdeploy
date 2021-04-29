<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GearPiece extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gear_piece_name',
        'gear_piece_desc',
        'gear_piece_id',
        'gear_piece_main',
        'gear_piece_sub_1',
        'gear_piece_sub_2',
        'gear_piece_sub_3',
        'gear_piece_type',
    ];

    public function gears()
    {
        return $this->belongsToMany(Gear::class, 'gear_gearpiece');
    }
}
