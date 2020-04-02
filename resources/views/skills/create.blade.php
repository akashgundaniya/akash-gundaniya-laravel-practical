@extends('layouts.app')
@push('stylesheets') 

@endpush
@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5"> 
               @if( isset($categories) )
                 <h2>{{ __('Edit Skill') }}</h2>
               @else
                 <h2>{{ __('Add New Skill') }}</h2>
              @endif
               <div class="d-flex">
                <a href="{{ url('/') }}" class="text-muted mb-0 hover-cursor"><i class="mdi mdi-home text-muted hover-cursor"></i>Dashboard<a/>
                &nbsp;/&nbsp; 
                <span class="mb-0 hover-cursor text-primary">
                   @if( isset($categories) )
                    {{ __('Edit Skill') }} 
                   @else
                     {{ __('Add New Skill') }}
                  @endif
                </span> 
              </div>
            </div> 
          </div> 
        </div>
      </div>
  </div>  
    @if (\Session::has('success'))
      <div class="alert alert-success">
          {!! \Session::get('success') !!}
      </div>
    @endif
      @if (count($errors) > 0)
        <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                  {{ $error }} <br>
              @endforeach
        </div>
    @endif

    <form id="UserForm" name="ParkingForm" action="@yield('editId',route('skill.index'))" method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
      {{csrf_field()}}
      @section('editMethod')
      @show 
      @csrf
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group row">
                <label for="name" class="col-md-12 col-form-label">{{ __('Skill Name') }}</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ ( ( isset($skill->name) ) ? $skill->name : old('name') ) }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div> 
            </div>
            <div class="card-footer">
              <input type="submit" name="" value="Submit" class="btn btn-primary mr-2">
              <a class="btn btn-light" href="{{ route('skill.index') }}">{{ __('Cancel') }}</a>
            </div>  
          </div>
        </div> 
      </div>
    </form>

@include('modals.delete')
@endsection

@push('scripts') 
  
@endpush