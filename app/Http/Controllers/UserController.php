<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Void_;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status'=> 200,
            'users'=>$users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //$this->middleware("auth:api");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return //JsonResponse
     */
    public function store(Request $request)
    {

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'birthday' => $request['birthday'],
            'phone'=> $request['phone'],
            'initial_weight'=>$request['initial_weight']

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        $userid = Auth()->id();

        return view('users.userprofile', compact('userid'));
    }

    public function showEdit()
    {
        $userid = Auth()->id();
        return view('users.editprofile',compact('userid'));
    }
    public function showAllUsers()
    {
        return view('users.userindex');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUser(int $id)
    {
        $user = User::findOrFail($id);

        return $user->toJson();
    }

    /**
     * helper function for update()
     * @param $then
     * @return false|string
     */
    public function getAge($then) {
        $then = date('Ymd', strtotime($then));
        $diff = date('Ymd') - $then;
        return substr($diff, 0, -4);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     * Validation is done in the front end
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \App\Models\User
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);
        if($user)
        {
            $user->treatment_group = $request->state['treatment_group'];
            $user->phone = $request->state['phone'];
            $user->current_weight = $request->state['current_weight'];
            $user->birthday = $request->state['birthday'];
            $user->first_name = $request->state['first_name'];
            $user->last_name = $request->state['last_name'];
            $user->rest_heart_rate = $request->state['rest_heart_rate'];
            $user->gender = $request->state['gender'];
            $user->age = $this->getAge($request->state['birthday']);
            $user->update();

            return response()->json([
                'status'=> 200,
                'message'=>'User Updated Successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No User ID Found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->delete();
            return response()->json([
                'status'=> 200,
                'message'=>'User Deleted Successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No User ID Found',
            ]);
        }
    }


}
