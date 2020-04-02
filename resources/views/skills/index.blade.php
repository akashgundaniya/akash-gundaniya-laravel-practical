@extends('layouts.app')
@push('stylesheets')
    <!-- Example -->
    <!--<link href=" <link href="{{ asset("css/myFile.min.css") }}" rel="stylesheet">" rel="stylesheet">-->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('public/assets/plugins/iCheck/all.css') }}">
@endpush
@section('content')  
    <div class="container"> 
      <div class="page-header">
          <a href="{{ route('skill.create') }}" class="btn btn-primary btn-sm">Add Skill </a>
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
      <div class="card">
        <div class="card-body">
          <table class="table table-striped data-table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>  
     </div> 
    </div> 
@include('modals.delete')
@endsection

@push('scripts')  
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 
  <script type="text/javascript">
  $(function () {  
    $('#confirmDelete').on('show.bs.modal', function (e) {
          $message = $(e.relatedTarget).attr('data-message');
          $(this).find('.modal-body p').text($message);
          $title = $(e.relatedTarget).attr('data-title');
          $(this).find('.modal-title').text($title);

          // Pass form reference to modal for submission on yes/ok
          var form = $(e.relatedTarget).closest('form');

          //$(this).find('.modal-footer #confirm').data('form', form);
          $(this).find('.modal-footer #confirm').data('form',form);
    }); 

    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        $(this).data('form').submit();
    }); 
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax: {
            url: "{{ route('getSkills' )}}",
            data: function (d) {
                //d.plate = $('input[name=plate]').val();
                d.name = $('input[name=name]').val(); 
                d.price = $('input[name=email]').val();
            }
          },
          columns: [
              {data: 'id', name: 'id'}, 
              {data: 'name', name: 'name'}, 
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
    }); 
  });
</script>
@endpush