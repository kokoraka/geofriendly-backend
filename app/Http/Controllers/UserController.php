<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {

    public function __construct() {
        
    }

    public function all() {
        return response()->json([
            'status' => true, 
            'message' => 'Success retrieve all users', 
            'code' => 200,
            'data'=> User::all()
        ]);
    }

    public function create(Request $request) {
        $this->validate($request, [            
            'name' => 'required|string|min:4|max:50',
            'username' => 'required|string|min:6|max:15|regex:/^[A-Za-z0-9]+$/|unique:user',
            'password' => 'required|string|between:6,20',
        ]);

        $data = $request->all();
        if ($data = User::store($data)) {
            return response()->json([
                'status' => true, 
                'message' => 'Success add new user', 
                'code' => 201,
                'data'=> $data
            ]);
        }
        return response()->json([
            'status' => false, 
            'message' => 'Failed to add new user', 
            'code' => 500,
            'data'=> []
        ]);
    }

    public function retrieve($id) {
        if ($id && $data = User::find($id)) {
            return response()->json([
                'status' => true, 
                'message' => 'Success retrieve user', 
                'code' => 200,
                'data'=> $data
            ]);
        }
        return response()->json([
            'status' => false, 
            'message' => 'User not found',
            'code' => 404, 
            'data'=> []
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [            
            'name' => 'required|string|min:4|max:50',
            'password' => 'required|string|between:6,20',
        ]);
        $data = $request->all();
        if ($id && $data = User::change($id, $data)) {
            return response()->json([
                'status' => true, 
                'message' => 'Success update user',
                'code' => 200, 
                'data'=> $data
            ]);
        }
        return response()->json([            
            'status' => false, 
            'message' => 'Failed update user', 
            'code' => 500,
            'data'=> []
        ]);
    }

    public function delete($id) {
        if ($id) {
            if ($data = User::erase($id)) {
                return response()->json([
                    'status' => true, 
                    'message' => 'Success delete user',
                    'code' => 200, 
                    'data'=> []
                ]);
            }
            return response()->json([            
                'status' => false, 
                'message' => 'Failed delete user', 
                'code' => 500,
                'data'=> []
            ]);
        }
        return response()->json([
            'status' => false, 
            'message' => 'User not found',
            'code' => 404, 
            'data'=> []
        ]);
    }
}