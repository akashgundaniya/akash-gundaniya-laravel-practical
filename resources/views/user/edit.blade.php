@extends('layouts.app')

@section('content')
<div class="container">
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
    <div class="card">
        <div class="card-header">{{ __('My Skills') }}</div>
        <form class="forms-sample" action="{{ route('user.skill.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT"> 
            @csrf 
            <div class="card-body"> 
                <div class="form-group row">
                    <label for="first_name" class="col-md-12 col-form-label">{{ __('Set your skills') }}</label>

                    <div class="col-md-12">  
                        <select name="skills[]" class="form-control" multiple="">
                            @foreach($skills as $key => $value)
                                <option value="{{ $key }}"  {{ ( isset( $selectedSkills ) && in_array( $key ,$selectedSkills ) ? 'selected':'') }}>{{ $value }}</option>
                            @endforeach
                        </select>    

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>   
            </div>
            <div class="card-footer"> 
                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button> 
            </div> 
        </form>
    </div> 
</div>
@endsection
