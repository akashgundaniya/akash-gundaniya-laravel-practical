@extends('layouts.app')
@push('stylesheets')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> 
@endpush
@section('content')
<div class="container"> 
    <div class="card">
        <div class="card-header">My Send Requests</div>

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
                            if($friend->followers->image):
                              $profileSrc = asset('uploads/profile/')."/".$friend->followers->image;
                            endif;
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12" id="{{ $friend->id }}">
                            <div class="card mcard"> 
                              <img class="card-img-top" src="{{ $profileSrc }}" alt="Avatar" />
                              <div class="m-card-header">
                                <span>Friend since <date>{{ date('d M, Y', strtotime($friend->followers->created_at)) }}</date></span>
                              </div>
                              <div class="card-body">
                                <h5 class="card-title mb-0">{{ $friend->followers->username }}</h5>  
                                 @if($friend->status == 0 )
                                    <label class="badge badge-info">Request Panding</label> 
                                 @elseif($friend->status == 2 )
                                    <label class="badge badge-danger">Request Rejected</label>
                                 @endif 
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
               $('#'+sendTo).remove();
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
