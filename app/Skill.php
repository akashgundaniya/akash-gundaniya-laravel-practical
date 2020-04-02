<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * The has Many Relationship
     *
     * @var array
    */
    public function mySkills()
    {
        return $this->hasMany('App\Userskill', 'skill_id');
    }

    	public function mySkill()
    {
        return $this->hasOne('App\Userskill', 'skill_id');
    }
}
