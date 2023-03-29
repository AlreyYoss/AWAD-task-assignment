@extends('app')
@section('content')
    <nav class="navbar fixed-top navbar-light bg-light">
        Nav Bar
    </nav>

    <div class="container p-5">
        <div>
            <div class="float-start">
                <h1>Task Assignments</h1>
            </div>

            <div class="float-end">
                <a href="{{url('create')}}" class="btn btn-success">Create New Task</a>
            </div>
            <div class="clearfix"></div>
        </div>    
    
        <div class="card mt-3">
            <h5 class="card-header">
                List of task
            </h5>

            <div class="card-body">
                <div class="card-text">
                    <div class="float-start">
                        Task 1
                    </div>

                    <div class="float-end">
                        <a href="#" class="btn btn-warning">Edit Task</a>
                        <a href="#" class="btn btn-danger">Delete Task</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
       
    </div>
@endsection