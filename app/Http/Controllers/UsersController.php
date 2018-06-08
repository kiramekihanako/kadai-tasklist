<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // add

use App\Task;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
     public function show($id)
    {   
        $task = Task::find($id);
         if (\Auth::user()->id === $task->user_id) {
        $user = User::find($id);
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'tasks' => $tasks,
        ];

        $data += $this->counts($user);

        return view('tasks.show', $data);
         }
         
         return redirect('/');
       
    }    
}