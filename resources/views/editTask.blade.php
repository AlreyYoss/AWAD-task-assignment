{{-- @extends('app') --}}
@extends('layouts.app')

@section('content')
<div class="container p-5 border border-2 rounded mt-5 ">
  <div class="row mb-3">
    <a class="col-4" href="{{url('home')}}" class="previous round "><i class="fa fa-angle-left fa-2x" style="color:red;" aria-hidden="true"></i></a>
    <div class="col">
      <h1>Edit task</h1>
    </div>
  </div>
  <form action="{{url('/save/task')}}/{{$data['id']}}" id="taskForm" method="post" enctype="multipart/form-data">
    @csrf
    
    
    <div class="mb-3 row">
      <label for="title" class="col-sm-2 col-form-label">Task Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="title" id="title" value="{{$data['title']}}" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Task Description</label>
      <textarea class="form-control" id="description" name="description" rows="3" required>{{$data['description'] ?? ''}}</textarea>
    </div>
    <div class="mb-3">
      <label for="upload" class="form-label">Uploaded file: </label>
      <a href="{{$data['upload']}}" download="{{$data['assigner_file_name']}}">{{$data['assigner_file_name']??'No file found'}}</a>
    </div>
    <div class="mb-3">
      <label for="upload" class="form-label">Upload file <small style="color:red;">*Previous file will be deleted(if any)</small></label>
      <input class="form-control" type="file" id="upload" name="upload">
    </div>
    
    <div class="mb-3 row">
      <label for="receiver_email" class="col-sm-2 col-form-label">Receiver E-mail</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="receiver_email" name="receiver_email" value="{{$data['email']}}" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="due_date" class="col-sm-2 col-form-label">Due date</label>
      <div class="col-sm-3">
           <input class="form-control" type="date" name="due_date" min="{{ date('Y-m-d') }}" value="{{$data['due_date']}}" required>  
        </div>  
      </div>
    </div>
    <div class="mt-5 text-center"><input class="btn btn-primary profile-button" type="submit" value="Save Task"></div>
  </form>
</div>
@endsection