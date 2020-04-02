@extends('layouts.app')
@push('stylesheets')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> 
@endpush
@section('content')
<div class="container"> 
    <div class="card">
        <div class="card-header">My Friends</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif  
            <div class="mathing-users-wrap">
                 <div class="row">
                    @foreach($other_users as $friend)
                        @php
                          $profileSrc = "https://cdn0.iconfinder.com/data/icons/user-pictures/100/unknown2-512.png";
                            if($friend->image):
                              $profileSrc = asset('uploads/profile/')."/".$friend->image;
                            endif;
                        @endphp
                        <div class="col-sm-12 col-md-4" id="{{ $friend->id }}">
                            <div class="card mcard"> 
                              <img class="card-img-top" src="{{ $profileSrc }}" alt="Avatar" />
                              <div class="m-card-header">
                                <span>Friend since <date>{{ date('d M, Y', strtotime($friend->created_at)) }}</date></span>
                              </div>
                              <div class="card-body">
                                <h5 class="card-title">{{ $friend->username }}</h5>  
                                  <a href="javascript:void(0)" class="btn btn-primary unfriend request-action" data-user="{{ $friend->id }}" data-sendby="{{ $friend->pivot->send_by }}" data-sendto={{ $friend->pivot->send_to }}>Unfriend</a>
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
     $('.request-action').click(function(){
        var user = $(this).attr('data-user');
        var sendBy = $(this).attr('data-sendby');
        var sendTo = $(this).attr('data-sendto');
     
        $.ajax({
            type: "POST",
            url: "{{ route('friend.unfriend') }}",
            dataType: 'JSON',
            data:{
               "_token": "{{ csrf_token() }}",
               "sendBy":  sendBy,  
               "sendTo":  sendTo,  
            },
            success: function (data) {
               $('#'+user).remove();
                 swal({
                    title: "Thank You!",
                    text: data.message,
                    timer: 2000
                  });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
     })  
  });
</script>
@endpush
