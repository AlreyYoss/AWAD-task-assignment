<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Employer;

class ProfileController extends Controller
{
    //
    function updateEmployeeProfile (Request $request)
    {
        $data = Employee::find($request ->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();
        return redirect("/home/employee/profile");
    }

    function updateEmployerProfile (Request $request)
    {
        $data = Employer::find($request ->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();
        return redirect("/home/employer/profile");
    }

    // public function getTasks ()
    // {
    //     $task = Task::latest()->where('status', 1)->paginate(5);

    //     return view("/home/employee/profile", compact('task'));
    // }

}
