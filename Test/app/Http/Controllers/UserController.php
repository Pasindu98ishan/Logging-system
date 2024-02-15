<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     /**
 * Display the index page.
 *
 * @return \Illuminate\Contracts\View\View
 */
public function index()
{
    return view('users.index');
}

/**
 * Retrieve all users and return as a list.
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function list()
{
    $users = User::all();
    return $users;
}

/**
 * Display a specific user.
 *
 * @param  string $id
 * @return \Illuminate\Contracts\View\View
 */
public function show(string $id)
{
    return view('users.show')->with('user', User::find($id));
}

/**
 * Retrieve and return a user for editing.
 *
 * @param  string $id
 * @return \App\Models\User
 */
public function edit(string $id)
{
    $user = User::find($id);
    return $user;                       
}

/**
 * Update a user's information.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  string $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(Request $request, string $id)
{
    $request->validate([
       'user_name' => 'required',
       'name' => 'required',
       'email' => 'required',
    ]);
    $input = $request->all();
    $user = User::find($id);
    $user->update($input);
    return response()->json(['message' => 'User updated successfully'], 200);
}

/**
 * Switch between deactivating and activating a user.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  string $id
 * @return \Illuminate\Http\JsonResponse
 */
public function switch(Request $request, string $id)
{
    $user = User::find($id);
    if ($user->status == 'active') {
        $user->deactivate();
        return response()->json(['message' => 'User deactivated successfully'], 200);
    } else {
        $user->activate();
        return response()->json(['message' => 'User activated successfully'], 201); // Return 201 for successful activation
    }
}

/**
 * Sort the users table based on the selected column.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  string $column
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function sort(Request $request, string $column)
{
    $direction = $request->input('direction');
    return User::orderBy($column, $direction)->get();
}

}
