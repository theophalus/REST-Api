<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $usersCollection = new Collection($users, new UserTransformer());
        $data = fractal($usersCollection)->toArray();
        return response()->json($data);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $userItem = new Item($user, new UserTransformer());
        $data = fractal($userItem)->toArray();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $userItem = new Item($user, new UserTransformer());
        $data = fractal($userItem)->toArray();
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        $userItem = new Item($user, new UserTransformer());
        $data = fractal($userItem)->toArray();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
