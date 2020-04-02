<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Skill;
use App\Userskill;

class UserController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function edit(){
		$user = Auth::user();
		// get user selected skills
		$getSkills = $user->mySkills; 
		$selectedSkills = ($getSkills) ? $getSkills->pluck('skill_id')->toArray() : array();
		$skills = Skill::get()->pluck('name','id');
		return view('user.edit' , compact('user','skills','selectedSkills' ) );
	}
	public function update(Request $request, $id){
		$user = User::find($id);

		// remove user old skills
		Userskill::where( 'user_id',$user->id )->delete();
		$skills = $request->get('skills'); 
     	if( !empty( $skills ) ):
            foreach( $skills as $sId ):
                $userSkill = new Userskill();
                $userSkill->user_id     = $user->id; 
                $userSkill->skill_id     = $sId;
                $userSkill->save();
            endforeach;
        endif;  
		return redirect()->route('user.profile')->with('success','Skill update successfully!'); 
	}

    public function updateProfileImage(Request $request){
        $user = Auth::user();

         if ($request->hasFile('profile')) {
            $image = $request->file('profile');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/profile');
            $image->move($destinationPath, $name);
       
            $user->image = $name;
            $user->save();
            return redirect()->route('home')->with('success','Profile image uploaded');  
        }else{
            return redirect()->route('home')->with('warning','Please Upload new image'); 
        } 
    }
}
