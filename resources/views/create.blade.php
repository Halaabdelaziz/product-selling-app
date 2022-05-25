<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@extends('layouts.app')

@section('content')
<div class="container">
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
  });

</script>