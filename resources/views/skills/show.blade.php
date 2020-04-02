@extends('admin.layouts.app')
@push('stylesheets') 

@endpush
@section('content')

<div class="content-wrapper">
  <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5"> 
              <h2>All Categories</h2> 
               <div class="d-flex">
                <a href="{{ url('/') }}" class="text-muted mb-0 hover-cursor"><i class="mdi mdi-home text-muted hover-cursor"></i>Dashboard<a/>
                &nbsp;/&nbsp; 
                <span class="mb-0 hover-cursor text-primary">All Categories</span> 
              </div>
            </div> 
          </div>
          <div class="d-flex justify-content-between align-items-end flex-wrap"> 
            <a href="{{route('categories.create')}}" class="btn btn-primary mt-2 mt-xl-0"> Add </a> &nbsp;
            <a href="{{route('categories.edit',$category->id)}}" class="btn btn-success mt-2 mt-xl-0"> Edit </a>&nbsp;
            <form action="{{route('categories.destroy', $category->id)}}" method="post" style="display:inline-block; vertical-align: middle; margin: 0;" id="{{$category->id}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this category?" class="btn btn-danger btn-fw">Delete</button></form>
          </div>
        </div>
      </div>
  </div> 
               
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
             <p><label>Name: </label> {{ $category->name }} </p>  
          </div>  
        </div>  
    </div>  
  </div>  
</div>  
@include('modals.delete')
@endsection

@push('scripts') 
  
@endpush