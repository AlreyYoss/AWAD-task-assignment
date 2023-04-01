@extends('layouts.app')
@section('style')
<style>
    .modal-card{
        transition: opacity 0.6s ease;
    }
    .modal-card:hover{
        opacity: 0.25;
        cursor: pointer;
    }
</style>
@endsection
@section('content')  
    <div class="container p-5">
        @include('status-bar')
        <div>
            <div class="float-start">
                <h1>Task Assignments</h1>
            </div>

            <div class="float-end">
                <a href="{{url('create')}}" class="btn btn-success">Create New Task</a>
            </div>
            <div class="clearfix"></div>
        </div>    
        @if(!empty($tasks['assigned']))
        <div class="card mt-3">
            <a class="card-header h5" style="text-decoration:none;color:rgb(127, 168, 255)" data-bs-toggle="collapse" href="#collapseAssigned" role="button" aria-expanded="false" aria-controls="collapseAssigned">
                List of Assigned Tasks
            </a>
            
            @if(empty($tasks))
            <div class="collapse" id="collapseAssigned">
                <div class="card-body">
                    <div class="card-text text-center">
                        No task found
                    </div>
                </div>
            </div>
            @endif
            @foreach($tasks['assigned'] as $task)
            <div class="collapse" id="collapseAssigned">
                <div class="card-body border-bottom">
                    <div class="card-text">
                        <div class="row d-flex">
                            <div class="col-xl-9 col-sm-7 col-6 modal-card"  data-bs-toggle="modal" data-bs-target="#task-info" data-task="{{$task}}">
                                <h5 class="d-inline-block">{{$task['title']}}</h5>
                                <span class="badge rounded-pill bg-info text-dark ">Due on: {{$task['due_date']}}</span>
                                <p>{{$task['description']}}</p>
                            </div>
                            <div class="col-xl-3 col-sm-5 col-6 ms-auto ">
                                <a href="{{url('edit/task')}}/{{$task['id']}}" class="btn btn-warning" id="action-button">Edit Task</a>
                                <a href="{{url('delete/task')}}/{{$task['id']}}" class="btn btn-danger">Delete Task</a>
                            </div>
                            
                        </div>

                        
                    </div>
                </div>
            </div>
            
            @endforeach
           
        </div>
        @endif
        @if(!empty($tasks['submitted']))
        <div class="card mt-3">
            <a class="card-header h5" style="text-decoration:none;color:gold" data-bs-toggle="collapse" href="#collapseSubmitted" role="button" aria-expanded="false" aria-controls="collapseSubmitted">
                List of Submitted Tasks
            </a>
            
            @if(empty($tasks['submitted']))
            <div class="collapse" id="collapseSubmitted">
                <div class="card-body">
                    <div class="card-text text-center">
                        No task found
                    </div>
                </div>
            </div>
            @endif
            @foreach($tasks['submitted'] as $task)
            <div class="collapse" id="collapseSubmitted">
                <div class="card-body border-bottom">
                    <div class="card-text">
                        <div class="row d-flex">
                            <div class="col-xl-9 col-sm-7 col-6 modal-card"  data-bs-toggle="modal" data-bs-target="#task-info" data-task="{{$task}}">
                                <h5 class="d-inline-block">{{$task['title']}}</h5>
                                <span class="badge rounded-pill bg-success text-dark ">Submitted</span>
                                <p>{{$task['description']}}</p>
                            </div>
                            <div class="col-xl-3 col-sm-5 col-6 ms-auto ">
                                <a href="{{url('edit/task')}}/{{$task['id']}}" class="btn btn-warning" id="action-button">Edit Task</a>
                                <a href="{{url('delete/task')}}/{{$task['id']}}" class="btn btn-danger">Delete Task</a>
                            </div>
                            
                        </div>

                        
                    </div>
                </div>
            </div>
            
            @endforeach
           
        </div>
        @endif
        @if(!empty($tasks['late']))
        <div class="card mt-3">
            <a class="card-header h5" style="text-decoration:none;color:red" data-bs-toggle="collapse" href="#collapseLate" role="button" aria-expanded="false" aria-controls="collapseLate">
                List of Overdue Tasks
            </a>
            
            @if(empty($tasks['late']))
            <div class="collapse" id="collapseLate">
                <div class="card-body">
                    <div class="card-text text-center">
                        No task found
                    </div>
                </div>
            </div>
            @endif
            @foreach($tasks['late'] as $task)
            <div class="collapse" id="collapseLate">
                <div class="card-body border-bottom">
                    <div class="card-text">
                        <div class="row d-flex">
                            <div class="col-xl-9 col-sm-7 col-6 modal-card"  data-bs-toggle="modal" data-bs-target="#task-info" data-task="{{$task}}">
                                <h5 class="d-inline-block">{{$task['title']}}</h5>
                                <span class="badge rounded-pill bg-danger text-dark ">Due on: {{$task['due_date']}}</span>
                                <p>{{$task['description']}}</p>
                            </div>
                            <div class="col-xl-3 col-sm-5 col-6 ms-auto ">
                                <a href="{{url('edit/task')}}/{{$task['id']}}" class="btn btn-warning" id="action-button">Edit Task</a>
                                <a href="{{url('delete/task')}}/{{$task['id']}}" class="btn btn-danger">Delete Task</a>
                            </div>
                            
                        </div>

                        
                    </div>
                </div>
            </div>
            
            @endforeach
           
        </div>
        @endif
    </div>
    <!-- Modal -->
<div class="modal fade" id="task-info" tabindex="-1" aria-labelledby="modal-task-title" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-task-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-between">
                <div>
                    <p><strong>Description: </strong></p>
                    <span id="modal-task-description" ></span>
                </div>
                
                <div>
                    <p><strong>Assigned on: </strong><span id="modal-task-assignedDate"></span></p>
                    <p><strong>Due date: </strong><span id="modal-task-date"></span></p>
                </div>
                
            </div>
          <p class="mt-3"><strong>Status: </strong><span class="badge" id="modal-task-status"></span></p>
          <p><strong>Assigned to: </strong><span id="modal-task-email"></span></p>
          <p><strong>Uploaded Doc: </strong><a href="" id="modal-task-upload"></a></p>
        </div>
        <div class="modal-footer">
            <a href="" class="btn btn-warning" id="modal-task-edit">Edit Task</a>

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script>
    var taskModal = document.getElementById('task-info')
        taskModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget // Button that triggered the modal
        console.log(button.getAttribute('data-task'));
        var task = JSON.parse(button.getAttribute('data-task')) // Extract info from data-* attributes
        $('#modal-task-title').text(task.title);
        $('#modal-task-description').text(task.description);
        if(task.status == 'assigned'){
            $('#modal-task-status').toggleClass('bg-primary');
        }
        else if(task.status == 'submitted'){
            $('#modal-task-status').toggleClass('bg-success');
        }
        else if(task.status == 'late'){
            $('#modal-task-status').toggleClass('bg-danger');
        }
        $('#modal-task-status').text(task.status);
        $('#modal-task-email').text(task.email);
        
        if(task.upload != null){
            $('#modal-task-upload').text(task.assigner_file_name);
            $('#modal-task-upload').attr("href", "{{ asset("") }}"+task.upload);
            var file_name = (task.assigner_file_name).split(".")[0];
            console.log("here "+file_name);
            $('#modal-task-upload').attr("download", file_name);
        }
        $('#modal-task-date').text(task.due_date);
        $('#modal-task-assignedDate').text(task.assigned_on);
        $('#modal-task-edit').attr("href", "{{ url('edit/task') }}"+'/'+task.id);
        
        // var modalBodyInput = modal.querySelector('#mydata')
        // modalBodyInput.textContent = myData // Display extracted data in the modal
        })

        $('#action-button').click(function(event) {
            event.stopPropagation();
            // do something else here
        });
        
</script>
@endsection