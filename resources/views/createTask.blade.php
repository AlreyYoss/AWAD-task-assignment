{{-- @extends('app') --}}
@extends('layouts.app')
@section('content')

<div class="container p-5 border border-2 rounded mt-5 ">
  <div class="row mb-3">
    <a class="col-4" href="{{url('employer')}}" class="previous round "><i class="fa fa-angle-left fa-2x" style="color:red;" aria-hidden="true"></i></a>
    <div class="col">
      <h1>Create new task</h1>
    </div>
  </div>
  <form action="{{url('/create/task')}}" id="taskForm" method="post" enctype="multipart/form-data">
    @csrf
    
    
    <div class="mb-3 row">
      <label for="title" class="col-sm-2 col-form-label">Task Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="title" id="title" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Task Description</label>
      <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label for="upload" class="form-label">Upload file</label>
      <input class="form-control" type="file" id="upload" name="upload">
    </div>
    <div class="mb-3 row">
      <label for="receiver_email" class="col-sm-2 col-form-label">Receiver E-mail</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="receiver_email" name="receiver_email" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="due_date" class="col-sm-2 col-form-label">Due date</label>
      <div class="col-sm-3">
           <input class="form-control" type="date" name="due_date" min="{{ date('Y-m-d') }}" required>  
        </div>  
      </div>
    </div>
    <div class="mt-5 text-center"><input class="btn btn-primary profile-button" type="submit" value="Create Task"></div>
  </form>
</div>

@endsection