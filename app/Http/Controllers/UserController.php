<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $users = User::orderByDesc('created_at')->paginate(10);

        return view('admin.user.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
            'specialist' => 'required|string'
        ]);

        $model = new User();
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);

        $picture = $request->file("image");
        if ($picture) {
            $path = public_path("images/users/");
            $image_name = time() . $picture->getClientOriginalName();
            $picture->move($path, $image_name);
            $model->image = asset("images/users/$image_name");
        }

        $model->role = $request->role;
        $model->specialist = $request->specialist;
        $model->is_active = $request->is_active;
        $model->save();

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        return view('admin.user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        return view('admin.user.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|max:255'
        ]);

        $model = User::find($id);
        if (!$model){
            return redirect(route('users.index'));
        }
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->email = $request->email;
        if ($request->filled('password')) {
            $model->password = Hash::make($request->password);
        }
        $picture = $request->file("image");
        if ($picture) {
            $oldFilePath = 'images/users/' . basename($model->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $path = public_path("images/users/");
            $image_name = time() . $picture->getClientOriginalName();
            $picture->move($path, $image_name);
            $model->image = asset("images/users/$image_name");
        }

        if ($request->telegram_user) {
            $admin = Admin::where('user_id', $model->id)->first();
            if (!$admin) {
                $admin = new Admin();
                $admin->telegram_user_id = $request->telegram_user;
                $admin->user_id = $model->id;
                $admin->save();
            } else {
                $admin->telegram_user_id = $request->telegram_user;
                $admin->update();
            }
        }

        $model->role = $request->role;
        $model->specialist = $request->specialist;
        $model->is_active = $request->is_active;
        $model->save();

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        $oldFilePath = 'images/users/' . basename($user->image);
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $user->delete($id);

        return redirect(route('users.index'));
    }

    public function getMe(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.user.profile');
    }

    /**
     * @throws ValidationException
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        $user = Auth::user();
        $model = User::find($user->id);
        if (empty($model)){
            return redirect()->back();
        }
        if ($request->new_password)
        {
            $this->validate($request, [
                'old_password' => 'required|string|max:255',
                'new_password' => 'required|string|min:8|max:255',
            ]);
            if(!Hash::check($request->old_password, $user->password)){
                return redirect()->back();
            }
            $model->password = Hash::make($request->new_password);
        }
        $model->name = $request->name;
        $model->surname = $request->surname;
        $model->email = $request->email;
        $picture = $request->file("image");
        if ($picture) {
            $oldFilePath = 'images/users/' . basename($model->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $path = public_path("images/users/");
            $image_name = time() . '_' . $picture->getClientOriginalName();
            $picture->move($path, $image_name);
            $model->image = asset("images/users/$image_name");
        }
        $model->update();
        return redirect()->back();

    }
}
