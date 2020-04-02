<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userskill extends Model
{
    /**
     * The has belonsTo Relationship
     *
     * @var array
    */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The has belonsTo Relationship
     *
     * @var array
    */
    public function skill()
    {
        return $this->belongsTo('App\Skill', 'skill_id');
    }
}
