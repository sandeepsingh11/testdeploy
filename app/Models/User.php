<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }

    public function gearsets()
    {
        return $this->hasMany(Gearset::class);
    }

    /**
     * Get the most recent gears created for this user.
     * 
     * @param number $numOfGears number of gears to retrieve
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getRecentGears($numOfGears = 3)
    {
        $recentGears = $this->gears()
            ->latest()
            ->limit($numOfGears)
            ->get();

        return $recentGears;
    }

    /**
     * Get the most recent gearsets created for this user.
     * 
     * @param number $numOfGearsets number of gearsets to retrieve
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getRecentGearsets($numOfGearsets = 3)
    {
        $recentGearsets = $this->gearsets()
            ->latest()
            ->limit($numOfGearsets)
            ->get();
        
        return $recentGearsets;
    }

    /**
     * Get the user's gear count.
     * 
     * @param string $gearType get count of a specific gear type ['H', 'C', 'S']
     * 
     * @return int
     */
    public function getUserGearCount($gearType = '')
    {
        $gearTypes = ['H', 'C', 'S'];

        if ( (!empty($gearType)) && (in_array(strtoupper($gearType), $gearTypes)) ) {
            // get all of user's gears of a specific type        
            $count = $this->gears()
                ->join('base_gears', 'gears.base_gear_id', '=', 'base_gears.id')
                ->where('base_gears.base_gear_type', $gearType)
                ->count();
        }
        else {
            // get all of user's gears
            $count = $this->gears()
                ->join('base_gears', 'gears.base_gear_id', '=', 'base_gears.id')
                ->count();
        }

        return $count;
    }
}
