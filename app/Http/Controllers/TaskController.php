<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    //display tasks 
    public function home(){
        // $tasks = Task::orderBy('id', 'desc')->get();
        // return view('index', compact('tasks'));
        return view('home');
    }

    public function createTask(Request $request)
    {
        
        return redirect('home')->with('status','Successfully created');
    }
}
