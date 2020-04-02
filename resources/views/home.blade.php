@extends('layouts.app') 
@push('stylesheets')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> 
@endpush
@section('content')
<div class="container">
  @if (\Session::has('success'))
    <div class="alert alert-success">
        {!! \Session::get('success') !!}
    </div>
  @endif
  @if (\Session::has('warning'))
    <div class="alert alert-warning">
        {!! \Session::get('warning') !!}
    </div>
  @endif
  @if (count($errors) > 0)
    <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
              {{ $error }} <br>
          @endforeach
    </div>
  @endif  
  <div class="profile-image-wrap"> 
      <div class="row">
          <div class="col-md-6">
             <div class="profile-block">
                <form class="forms-sample" action="{{ route('updateProfileImage') }}" method="POST" enctype="multipart/form-data"> 
                @csrf
                @php 
                    $profileSrc = "https://cdn0.iconfinder.com/data/icons/user-pictures/100/unknown2-512.png";
                    if(Auth::user()->image):
                    $profileSrc = asset('uploads/profile/')."/".Auth::user()->image;
                    endif;

                @endphp
                <div class="prev-image">
                    <img src="{{ $profileSrc }}" />
                </div> 
                <div class="form-group image-field d-flex justify-content-center align-items-center"> 
                  <input type="file" name="profile" id="profile" />
                  <input type="submit" name="submit" class="btn btn-success" value="Update Image"/>
                </div>  
               </form>  
            </div> 
          </div> 
          <div class="col-md-6">
              <div class="my-skills">
                <h3> My Skills  <a class="btn btn-success" href="{{ route('skill.index') }}">{{ __('Add new skills') }}</a></h3>  
                <ul class="user-skills">
                  @foreach(Auth::user()->mySkills as $skill)
                    <li>{{ $skill->skill->name }}</li>
                  @endforeach
                </ul>
              </div>  
          </div> 
      </div>  
  </div>  
  <div class="card">
        <div class="card-header">Matching users</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif 
            <div class="mathing-users-wrap">
                 <div class="row">
                    @foreach($other_users as $otherUser)
                        @php
                          $profileSrc = "https://cdn0.iconfinder.com/data/icons/user-pictures/100/unknown2-512.png";
                            if($otherUser->image):
                              $profileSrc = asset('uploads/profile/')."/".$otherUser->image;
                            endif;
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12" id="{{ $otherUser->id }}">
                            <div class="card mcard"> 
                              <img class="card-img-top" src="{{ $profileSrc }}" alt="Avatar" />
                              <div class="m-card-header">
                                <span>Friend since <date>{{ date('d M, Y', strtotime($otherUser->created_at)) }}</date></span>
                              </div>
                              <div class="card-body">
                                <h5 class="card-title">{{ $otherUser->username }}</h5>
                                <div class="card-text">
                                  <ul class="user-skills">
                                    @foreach($otherUser->mySkills as $skill)
                                      <li>{{ $skill->skill->name }}</li>
                                    @endforeach
                                  </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary send-request" data-user="{{ $otherUser->id }}">Send Request</a>
                              </div>
                            </div> 
                        </div>
                    @endforeach
                 </div>   
            </div> 
        </div> 
    </div>
</div>
@endsection
@push('scripts')  
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
 
  <script type="text/javascript">
  $(function () {  
     $('.send-request').click(function(){
        var sendTo = $(this).attr('data-user');
        $.ajax({
            type: "POST",
            url: "{{ route('friend.request-send') }}",
            dataType: 'JSON',
            data:{
               "_token": "{{ csrf_token() }}",
               "send_to":  sendTo, 
            },
            success: function (data) {
               if(data.success){
                $('#'+sendTo).remove();
                  swal({
                    title: "Thank You!",
                    text: data.message,
                    timer: 2000
                  });
               } 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
     }) 
  });
</script>
@endpush
