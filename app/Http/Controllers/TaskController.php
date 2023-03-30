<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    //display tasks 
    public function home(){
        // $tasks = Task::orderBy('id', 'desc')->get();
        // return view('index', compact('tasks'));
        $tasks = Task::where('assigner_id',1)->where('status','assigned')->get();
        // dd($tasks);
        if(!empty($tasks)){
            for($i = 0; $i<count($tasks); $i++){
                $tasks[$i]['email'] = User::find($tasks[$i]['receiver_id'])->email;
                $tasks[$i]['assigned_on'] = $tasks[$i]['created_at']->format('Y-m-d');
                // dd(  $tasks[$i]['assigned_on']);
            }
            
        }
        // dd($tasks);
        return view('home',['tasks'=>$tasks,'data'=>session('data')?? null]);
    }

    public function createTask(Request $request)
    {
        
        $receiver_id = User::where('email',$request->input('receiver_email'))->value('id');
        if(empty($receiver_id)){
            $result = [
                'status' => 'Failed',
                'info'   => 'Invalid email input',
            ];
            return redirect('home')->with(['data'=>$result]);
        }

        // Handle the file upload
        if ($request->hasFile('upload')) {
            $upload = $request->file('upload');
            $oriName = $upload->getClientOriginalName();
            $name =  time().'.'.$upload->getClientOriginalExtension();
            $path = $upload->storeAs('public', $name);
        }

        

        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date'  => $request->input('due_date'),
            'receiver_id' => $receiver_id,
            'status'    => 'assigned',
            'upload'    => !empty($name)? 'storage/'.$name : null,
            'assigner_id' => 1,
            'assigner_file_name' => $oriName ?? null,
        ];
        Task::create($data);

        $result = [
            'status' => 'Success',
            'info'   => 'Created successfully',
        ];
        return redirect('home')->with(['data'=>$result]);
    }

    public function editTask($id){
        $data = Task::find($id);
        $data->email = User::find($data->receiver_id)->email;
        return view('editTask',['data'=>$data]);
    }

    public function saveTask(Request $request, $id){
        $receiver_id = User::where('email',$request->input('receiver_email'))->value('id');
        if(empty($receiver_id)){
            $result = [
                'status' => 'Failed',
                'info'   => 'Invalid email input',
            ];
            return redirect('home')->with(['data'=>$result]);
        }

        $task = Task::find($id);

        if ($request->hasFile('upload')) {
            $path = explode("/",$task->upload);
            $oldname = end($path);
            if (Storage::exists('public/'.$oldname)) {
                Storage::delete('public/'.$oldname);
            }
            $upload = $request->file('upload');
            $oriName = $upload->getClientOriginalName();
            $name =  time().'.'.$upload->getClientOriginalExtension();
            $path = $upload->storeAs('public', $name);
        }


        $task->title = $request->input('title') ?? $task->title;
        $task->description = $request->input('description') ?? $task->description;
        $task->receiver_id = $receiver_id;
        $task->due_date = $request->input('due_date');
        $task->upload = !empty($name)? 'storage/'.$name : null;
        $task->assigner_file_name = $oriName ?? $task->assigner_file_name;
        $task->save();

        $result = [
            'status' => 'Success',
            'info'   => 'Edit successfully',
        ];
        return redirect('home')->with(['data'=>$result]);
    }

    public function deleteTask($id){
        Task::destroy($id);

        $result = [
            'status' => 'Success',
            'info'   => 'Delete successfully',
        ];
        return redirect('home')->with(['data'=>$result]);
    }
}
