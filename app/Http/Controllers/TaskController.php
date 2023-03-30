<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Facades\DB;
use App\Models\Task;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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

    public function viewTask() {
        $data = Task::all();
        return view('homeStudent', ['tasks'=>$data]);
    }

    public function upload($id)
    {
        $data = Task::find($id);
        return view('upload', ['task' => $data]);
    }

    public function store(Request $req) {
            $this->validate($req, [
                        'filenames' => 'required',
                        'filenames.*' => 'mimes:doc,pdf,docx,zip,png,jpge,jpg'
                ]);
            $fileModel = Task::find($req->id);
            if ($req->hasFile('filenames')) {
                $fileName = "-";
                foreach($req->file('filenames') as $file){
                    $fileName = time().'_'.$file->getClientOriginalName();
                    $filePath = $file->storeAs('public', $fileName);
                    $fileModel->upload = $fileName;
                    $fileModel->save();
                }
                
                return back()
                ->with('success','File has been uploaded.')
                ->with('filenames', $fileName);
            }
    }

    public function download($id) {
        $task = Task::find($id);
        $filepath = storage_path().'/'.'app'.'/public/'.$task->upload;
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
