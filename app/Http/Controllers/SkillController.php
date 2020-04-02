<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use yajra\Datatables\Datatables; 
use Validator;
use Auth;
use App\Skill;

class SkillController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'skills.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'skills.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => ['required', 'max:100','unique:skills'], 
        ]); 

        $data = $request->all();

        if( isset( $data ) && !empty( $data ) ):

            $userId = Auth::id();

            $skill                = new Skill(); 
            $skill->name          = $data['name'];  
            $skill->save(); 
            if( $skill )
                return redirect()->route('skill.index' )
                        ->with('success','Skill created successfully');

        endif;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        
        return view('skills.show' , compact('skill' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    { 
        return view('skills.edit' , compact('skill' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        
        $this->validate($request, [
            'name'          => 'required' 
        ]); 

        $data = $request->all();

        if( isset( $data ) && !empty( $data ) ): 
            $skill->name          = $data['name'];  
            $skill->save(); 

            if( $skill )
                return redirect()->route('skill.index' )
                        ->with('success','Skills update successfully');

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    { 
        $skill->delete();
        return redirect()->route('skill.index')->with('success','Skill delete successfully!');
    }


    public function getAllSkills(){

        $items = Skill::get();
        
        return Datatables::of($items)  
            ->addColumn('action', function ($item) { 
                 
                 $action = '<a href="'.route("skill.edit", $item->id).'" class="btn btn-primary btn-sm btn-rounded btn-fw" style="margin-right:5px;"><i class="fa fa-pencil"></i> Edit</a>';
                $action .= '<form action="'.route("skill.destroy", $item->id).'" method="post" style="display:inline-block; vertical-align: middle; margin: 0;" id="'.$item->id.'">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this skill?" class="btn btn-danger btn-sm btn-rounded btn-fw">Delete</button></form>';
              
                return $action;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
}
