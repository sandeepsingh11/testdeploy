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
        'gear_id',
        'gear_main',
        'gear_sub_1',
        'gear_sub_2',
        'gear_sub_3',
        'gear_type',
    ];

    public function gearsets()
    {
        return $this->belongsToMany(Gearset::class, 'gear_gearset');
    }
}
