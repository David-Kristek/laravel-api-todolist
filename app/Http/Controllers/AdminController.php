<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request)
    {
        return response()->json([
            'msg' => 'admin',
        ]);
    }
    public function getUsers()
    {
        return DB::table('admins')->rightJoin('users', 'users.id', '=', 'user_id')->get();
    }
    public function removeUser($id)
    {
        return User::where('id', $id)->delete();
    }

    public function newAdmin($id)
    {
        return Admin::create([
            'user_id' => $id,
            'main' => false,
        ]);
    }
    public function removeAdmin($id)
    {
        return Admin::where('user_id', $id)->delete();
    }
    public function userInfo($id){
        
        $userInfo = User::where('id', $id)->first();
        $userPosts = Post::where('user_id', $id)->get();
        $admin = Admin::where('user_id', $id)->first();

        return response()->json([
            'userInfo' => $userInfo,
            'userPosts' => $userPosts,
            'admin' => $admin
        ]); 
    }
}
