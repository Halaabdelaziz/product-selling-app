<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@extends('layouts.app')

@section('content')
<div class="container" id="users-table">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
    <a class="btn btn-primary text-light "  id="create-user">Create User</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">phone</th>
        <th scope="col">image</th>
        <th scope="col">Created_at</th>
      </tr>
  </thead>
  <tbody>


    @foreach($users as $user)
          <tr> 
              <td>{{$user->id}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->phone}}</td>
              <td class="w-25"><img src='{{asset("images/$user->image")}}' class="img-fluid w-25"></td>
              <td>{{$user->created_at}}</td>
              <td><input id="deleteUser" data-id="{{ $user->id }}" data-token="{{csrf_token()}}" value="Delete" class="btn btn-danger"></td>
          </tr>
          @endforeach
          
  </tbody>

  </table>
</div>
</div>
@endsection


@section('content2')
<div class="container d-none" id="form-user">
<form action="/create" method="post" id="upload_form" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label for="exampleInputname" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="exampleInputname">
  </div>
  <div class="mb-3">
    <label for="exampleInputemail" class="form-label">Email</label>
    <input type="text" name="email" class="form-control" id="exampleInputemail">
  </div>
  <div class="mb-3">
    <label for="exampleInputpassword" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputpassword">
  </div>

  <div class="mb-3">
    <label for="exampleInputphone" class="form-label">phone</label>
    <input type="text" name="phone" class="form-control" id="exampleInputphone">
  </div>
  <!-- <div class="mb-3">
    <label for="exampleInputimage" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="exampleInputimage">
  </div> -->
  <button id="save-user" class="btn btn-primary">Submit</button>
</form>     
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    $(document).on('click','#create-user',function(){
        $('#users-table').hide();
        $('#form-user').removeClass('d-none');
    })
  $(document).on('click','#deleteUser',function(e){
    e.preventDefault();
    var id = $(this).data("id");
    var token = $(this).data("token");
    $.ajax({
      type:'DELETE',
      url:"users/"+id,
      data:{
        'id':id,
        '_token':token
      },
        success:function(data){
          console.log("it Works");
        },
        error:function(error){
          console.log(error);
        }

    });
  });
</script>

<script>
  $(document).on('click','#save-user',function(event){
    event.preventDefault();
    $.ajax({
      type:'post',
      url:"{{route('userStore')}}",
      data:{
        '_token':"{{csrf_token()}}",
        'name':$("input[name='name']").val(),
        'email':$("input[name='email']").val(),
        'password':$("input[name='password']").val(),
        'phone':$("input[name='phone']").val(),
        // 'image':$("input[name='image']").val(),
      },
        success:function(data){
          // window.location.href = "users";
          console.log(data);
        }, 
        error:function(reject){
          console.log(reject.responseText.message);
        }
    });
    $('#users-table').show();
    $('#form-user').addClass('d-none');
    $.ajax({
        type:'GET',
        url: "{{route('home')}}", 
        success: function(response) {
        appenddata='<li>';
            if (typeof(response)=='array') {
            appenddata+=response['message'];
        }
        if ( typeof(response)=='object') {
            appenddata+=response->message;
        }
        if ( typeof(response)=='string') {
            appenddata+=response;
        }
            appenddata+='</li>';
            $('#users-table').append(appenddata);

}
    });
  });

</script>

