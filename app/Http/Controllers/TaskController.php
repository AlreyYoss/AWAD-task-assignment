<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Employer;
use App\Models\Employee;
use App\Models\Task;

class TaskController extends Controller
{
    //display tasks 
    public function home(){
        // $tasks = Task::orderBy('id', 'desc')->get();
        // return view('index', compact('tasks'));
        // dd(Auth::user()->id);
        $employer_id = Auth::user()->id;
        $tasks['assigned'] = Task::where('assigner_id',$employer_id)->where('status','assigned')->get();
        $index = 0;
        foreach($tasks['assigned'] as $key=>$task){
            $today = Carbon::today();
            $due_date = Carbon::createFromFormat('Y-m-d',$task['due_date']);
            // dd($due_date);
            if($today->gt($due_date)){
                Task::where('id',$task['id'])->update(['status'=>'late']);
                unset($tasks['assigned'][$index]);
                // unset($tasks['assigned'][$key]);
            }
            $index++;
        }
        $tasks['submitted'] = Task::where('assigner_id',$employer_id)->where('status','submitted')->get();
        $tasks['late'] = Task::where('assigner_id',$employer_id)->where('status','late')->get();

        // dd($tasks);
        if(!empty($tasks)){
            foreach($tasks as $parentKey=>$task){
                foreach($task as $key=>$item){
                    $task[$key]['email'] = Employee::find($item['receiver_id'])->email;
                    $task[$key]['assigned_on'] = $item['created_at']->format('Y-m-d');
                    // dd(  $tasks[$i]['assigned_on']);
                }
            }
            
        }
        // dd($tasks);
        // dd($tasks);
        return view('home',['tasks'=>$tasks,'data'=>session('data')?? null]);
    }

    public function assigneeHome(){
        // $tasks = Task::orderBy('id', 'desc')->get();
        // return view('index', compact('tasks'));
        // dd(Auth::user()->id);
        $receiver_id = Auth::user()->id;
        $tasks['assigned'] = Task::where('receiver_id',$receiver_id)->where('status','assigned')->get();
        $index = 0;
        foreach($tasks['assigned'] as $key=>$task){
            $today = Carbon::today();
            $due_date = Carbon::createFromFormat('Y-m-d',$task['due_date']);
            // dd($due_date);
            if($today->gt($due_date)){
                Task::where('id',$task['id'])->update(['status'=>'late']);
                unset($tasks['assigned'][$index]);
                // unset($tasks['assigned'][$key]);
            }
            $index++;
        }
        $tasks['submitted'] = Task::where('receiver_id',$receiver_id)->where('status','submitted')->get();
        $tasks['late'] = Task::where('receiver_id',$receiver_id)->where('status','late')->get();
        
        // dd($tasks);
        if(!empty($tasks)){
            foreach($tasks as $parentKey=>$task){
                foreach($task as $key=>$item){
                    $task[$key]['email'] = Employer::find($item['assigner_id'])->email;
                    $task[$key]['assigned_on'] = $item['created_at']->format('Y-m-d');
                    // dd(  $tasks[$i]['assigned_on']);
                }
            }
            
        }
        // dd($tasks);
        // dd($receiver_id);
        return view('assigneeHome',['tasks'=>$tasks,'data'=>session('data')?? null]);
    }

    public function createTask(Request $request)
    {
        $request->validate([
            'upload' => 'mimes:doc,pdf,docx,zip,png,jpge,jpg',
            'receiver_email' => 'required|email',
            'title' => 'required',
            'description' => 'required',
            'due_date'  => 'required',
        ]);
        $receiver_id = Employee::where('email',$request->input('receiver_email'))->value('id');
        if(empty($receiver_id)){
            $result = [
                'status' => 'Failed',
                'info'   => 'Invalid email input',
            ];
            return redirect('employer')->with(['data'=>$result]);
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
            'assigner_id' => Auth::user()->id,
            'assigner_file_name' => $oriName ?? null,
        ];
        Task::create($data);

        $result = [
            'status' => 'Success',
            'info'   => 'Task Created Successfully',
        ];
        return redirect('employer')->with(['data'=>$result]);
    }

    public function editTask($id){
        $data = Task::find($id);
        $data->email = Employee::find($data->receiver_id)->email;
        return view('editTask',['data'=>$data]);
    }

    public function saveTask(Request $request, $id){
        $request->validate([
            'upload' => 'mimes:doc,pdf,docx,zip,png,jpge,jpg',
            'receiver_email' => 'required|email',
            'title' => 'required',
            'description' => 'required',
            'due_date'  => 'required',
        ]);
        $receiver_id = Employee::where('email',$request->input('receiver_email'))->value('id');
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
            'info'   => 'Task Edit Successfully',
        ];
        return redirect('employer')->with(['data'=>$result]);
    }

    public function deleteTask($id){
        Task::destroy($id);

        $result = [
            'status' => 'Success',
            'info'   => 'Task Delete Successfully',
        ];
        return redirect('employer')->with(['data'=>$result]);
    }


    public function upload($id)
    {
        $data = Task::find($id);
        return view('upload', ['task' => $data]);
    }

    public function store(Request $request) {
            $this->validate($request, [
                        'filenames' => 'required',
                        'filenames.*' => 'mimes:doc,pdf,docx,zip,png,jpge,jpg,txt'
                ]);
            $task= Task::find($request->id);
            if ($request->hasFile('filenames')) {
                if($task->receiver_upload != null){
                    $path = explode("/",$task->receiver_upload);
                    $oldname = end($path);
                    if (Storage::exists('public/'.$oldname)) {
                        Storage::delete('public/'.$oldname);
                    }
                }
                
                
                $receiver_upload = $request->file('filenames');
                $oriName = $receiver_upload->getClientOriginalName();
                $name =  time().'.'.$receiver_upload->getClientOriginalExtension();
                $path = $receiver_upload->storeAs('public', $name);

                $task->receiver_upload = !empty($name)? 'storage/'.$name : null;
                $task->receiver_file_name = $oriName;
                $task->save();
                $result = [
                    'status' => 'Success',
                    'info'   => 'Task Uploaded Successfully',
                ];

                return redirect('employee')
                ->with(['data'=>$result]);
                
            }
    }

    public function download($id) {
        $task = Task::find($id);
        $filepath = $task->upload;
        if (file_exists($filepath)) {
            return Response::download($filepath); 
        }
    }

        // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //             'filenames' => 'required',
    //             'filenames.*' => 'mimes:doc,pdf,docx,zip,png,jpge,jpg'
    //     ]);
    //     if($request->hasfile('filenames'))
    //      {
    //         foreach($request->file('filenames') as $file)
    //         {
    //             $name = time().'_'.$file->getClientOriginalName();
    //             $file->move(base_path() . '/storage/app/public', $name);
    //             $data[] = $name;
    //         }
    //      }
    //      $file= Task::find($request->id);
    //      $file->studentUploadPath=json_encode($data);
    //      $file->save();

    //      return back()
    //      ->with('success','File has been uploaded.');
    // }
}
