<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
      // friendship that this user started
    protected function friendsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'App\Friendship', 'first_user', 'second_user')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
    }
 
    // friendship that this user was asked for
    protected function thisUserFriendOf()
    {
        return $this->belongsToMany(User::class, 'App\Friendship', 'second_user', 'first_user')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
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
