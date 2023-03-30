
<html lang="en">
<head>
  <title>Submit File</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>
<body>
<div class="container">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <strong>There is something error please check your file</strong>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
<h3 class="well">Submit Your Tasks Here</h3>
<form method="post" action="{{url('upload/')}}/{{$task['id']}}" enctype="multipart/form-data">
  {{csrf_field()}}
    <div class="input-group" >
      <input type="file" name="filenames[]" class="myfrm form-control">
    </div>
    <button type="submit" class="btn btn-success w-100 p-3" style="margin-top:10px">Submit</button>
</form>
</div>
</body>
</html>