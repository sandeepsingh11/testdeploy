<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gear_name',
        'gear_desc',
        'gear_mode_rm',
        'gear_mode_cb',
        'gear_mode_sz',
        'gear_mode_tc',
        'gear_weapon_id',
        'gear_piece_h_id',
        'gear_piece_c_id',
        'gear_piece_s_id',
    ];
}
