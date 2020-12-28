<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\CheckUser;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\UpdatePasswordUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Rules\ValidCurrentUserById;
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
    public function update(UpdateUser $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->get('name');
            $user->save();
            return response()->json(['message' => 'User updated successfully.', $status = 200])->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], $status = 404)->setStatusCode(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordUser $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->password = $request->get('password');
            $user->save();
            return response()->json(['message' => 'Password updated successfully.', $status = 200])->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], $status = 404)->setStatusCode(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'Password updated successfully.', $status = 200])->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], $status = 404)->setStatusCode(404);
        }
    }
}
