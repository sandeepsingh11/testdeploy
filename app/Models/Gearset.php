<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gearset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gearset_title',
        'gearset_desc',
        'gearset_mode_rm',
        'gearset_mode_cb',
        'gearset_mode_sz',
        'gearset_mode_tc',
        'weapon_id',
    ];

    public function gears()
    {
        return $this->belongsToMany(Gear::class, 'gear_gearset');
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }
}
