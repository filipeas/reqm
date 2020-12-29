<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\CheckUser;
use App\Http\Requests\UpdatePasswordUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Check if user exists in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUser(CheckUser $request)
    {
        return User::where('email', $request->get('email'))->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUser $request)
    {
        return User::create($request->all(), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $user->name = $request->get('name');
        $user->save();
        return response()->json(['message' => 'User updated successfully.', $status = 200])->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordUser $request, User $user)
    {
        $user->password = $request->get('password');
        $user->save();
        return response()->json(['message' => 'Password updated successfully.', $status = 200])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id == $user->id)
            $user->delete();
        else
            return response()->json(['message' => 'User not found.', $status = 404])->setStatusCode(404);

        return response()->json(['message' => 'User removed successfully.', $status = 200])->setStatusCode(200);
    }
}
