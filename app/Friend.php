<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * The has belonsTo Relationship
     *
     * @var array
    */
    public function following()
    {
        return $this->belongsTo('App\User','send_by');
    }
    public function followers()
    {
        return $this->belongsTo('App\User','send_to');
    } 
}
