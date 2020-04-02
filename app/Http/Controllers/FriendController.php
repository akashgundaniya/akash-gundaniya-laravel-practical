<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Friend;


class FriendController extends Controller
{
    public function requestSend(Request $request){
    	$response = [];
		if($request->ajax()){
            $sendTo = $request->get('send_to');

            $friend = new Friend();
            $friend->send_by = Auth::user()->id;
            $friend->send_to = $sendTo;
            $friend->save(); 

            $response['success'] = true;
            $response['message'] = 'Friend request send successfully....';

        }

        return json_encode($response);
    } 
    public function requestStatusUpdate(Request $request){
        $response = [];
        if($request->ajax()){
            $requestId = $request->get('request_id');
            $status = $request->get('status');
            
            $update = Friend::where('id',$requestId)->update(array('status'=>$status));

            $response['success'] = true;
            $response['message'] = 'Friend request updated successfully....';

        }

        return json_encode($response);
    } 
     public function unfriend(Request $request){
        $response = [];
        if($request->ajax()){
            $sendBy = $request->get('sendBy');
            $sendTo = $request->get('sendTo');
         
            
            $update = Friend::where('send_by',$sendBy)->where('send_to',$sendTo)->delete();

            $response['success'] = true;
            $response['message'] = 'Unfriend successfully....';

        }

        return json_encode($response);
    } 
    public function newRequestGet(){
        $user = Auth::user(); 
        $other_users = $user->following()->where('status','0')->get();  
      //  dd( $other_users);
        return view('friends.request-list',compact('other_users'));
    }
    public function mySendRequests(){
        $user = Auth::user(); 
        $other_users = $user->followers()->where('status',"!=",'1')->get();
       
        return view('friends.sended-request-list',compact('other_users'));
    }
    public function myFriends(){
        $user = Auth::user();  
        $other_users = $user->friends;   
        return view('friends.friend-list',compact('other_users'));
    }
}
