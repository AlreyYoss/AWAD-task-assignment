{{-- @extends('app') --}}
@extends('layouts.app')
@section('content')

    <div class="container p-5">
        <div>
            <div class="float-start">
                <h1>Task Assignments</h1>
            </div>

            <div class="clearfix"></div>
        </div>    
    
        <div class="card mt-3">
            <h5 class="card-header">
                List of task
            </h5>
            @foreach ($tasks as $task)
            <div class="card-body">
                <div class="card-text">
                    <div class="float-start">
                        Task {{$task['id']}} : {{$task['title']}}
                    </div>

                    <div class="float-end">
                        Due Date : {{$task['due_date']}} 
                        &emsp;
                        <a href="{{url('download/')}}/{{$task['id']}}" class="btn btn-warning">Download Task</a>
                        <a href="{{url('upload/')}}/{{$task['id']}}" class="btn btn-danger">Submit Task</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            @endforeach
        </div>
       
    </div>
@endsection