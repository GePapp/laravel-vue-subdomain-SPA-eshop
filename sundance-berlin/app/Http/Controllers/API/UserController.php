<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();
    //   return ['message' => 'User Deleted'];
    }
}
