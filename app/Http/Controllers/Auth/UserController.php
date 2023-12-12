<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserCollection;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $users = $this->user->orderBy('created_at', $request->sort)->paginate($request->per_page);
        return new UserCollection($users);
    }

    public function register(UserRequest $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->rol,
            'city_id' => $request->city_id,
            'password' => bcrypt($request->password),
        ]);
        
        return response()->json(['success' => true, 'data' => $user], 200);
    }

    public function update(UserRequest $request, User $user)
    {
        $model = $this->user->find($user->id);

        $model->name = $request->name;
        $model->email = $request->email;
        $model->type = $request->rol;
        $model->city_id = $request->city_id;

        if ($request->password != "") {
            $model->password = bcrypt($request->password);
        }

        $model->save();

        return response()->json(['success' => true, 'data' => $model], 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(['success' => true], 200);
    }

    public function current(Request $request)
    {
        return response()->json($request->user());
    }
}
