@extends('app')
@section('content')
<div class="container p-5 border border-2 rounded mt-5 w-75">
 
  <form action="{{url('/create/task')}}" id="taskForm" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mt-2">
      <a href="{{url('home')}}" class="previous round"><i class="fa fa-angle-left fa-2x" style="color:red" aria-hidden="true"><span class="ms-2 fs-5 text-center">back</span></i></a>
    </div>
    <div class="row mb-3">
      <h1>Task Assignments</h1>
    </div>
    <div class="mb-3 row">
      <label for="title" class="col-sm-2 col-form-label">Task Title</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="title" id="title">
      </div>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Task Description</label>
      <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="upload" class="form-label">Upload file</label>
      <input class="form-control" type="file" id="upload" name="upload">
    </div>
    <div class="mb-3 row">
      <label for="receiver_email" class="col-sm-2 col-form-label">Receiver E-mail</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="receiver_email" name="receiver_email">
      </div>
    </div>
    <div class="mb-3 row">
      <label for="due_date" class="col-sm-2 col-form-label">Due date</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="due_date" name="due_date">
      </div>
    </div>
    <div class="mt-5 text-center"><input class="btn btn-primary profile-button" type="submit" value="Create Task"></div>
  </form>
</div>
@endsection