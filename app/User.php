<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','username', 'email', 'password','mobile','gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The has Many Relationship
     *
     * @var array
    */
    public function mySkills()
    {
        return $this->hasMany('App\Userskill', 'user_id');
    }
    public function mySkill()
    {
        return $this->hasOne('App\Userskill', 'user_id');
    }  

    public function follow()
    {
        return $this->hasOne('App\Friend', 'send_to');
    } 

    public function following()
    {
        return $this->hasMany('App\Friend', 'send_to');
    }

    public function follower()
    {
        return $this->hasOne('App\Friend', 'send_by');
    } 

    public function followers()
    {
        return $this->hasMany('App\Friend', 'send_by');
    }

    protected function friendsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'friends', 'send_to', 'send_by')
        ->withPivot('status')
        ->wherePivot('status', '1');
    }
 
    // friendship that this user was asked for
    protected function thisUserFriendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'send_by', 'send_to')
        ->withPivot('status')
        ->wherePivot('status', '1');
    }
 
    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();
        return $this->getRelation('friends');
    }
 
    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
        $friends = $this->mergeFriends();
        $this->setRelation('friends', $friends);
    }
    }
 
    protected function mergeFriends()
    {
        if($temp = $this->friendsOfThisUser)
        return $temp->merge($this->thisUserFriendOf);
        else
        return $this->thisUserFriendOf;
    } 
 
}
