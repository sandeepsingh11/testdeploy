<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'skill_name',
        'is_main',
    ];

    /**
     * Make a default skill model.
     * 
     * @return Skill A Skill instance of the created skill
     */
    public function makeDefaultSkill()
    {
        return new Skill([
            'skill_name' => 'Unknown',
            'is_main' => false
        ]);
    }
}
