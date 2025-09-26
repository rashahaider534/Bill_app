<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('user.show_users', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('user.Add_user', compact('roles'));
    }
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            //  'password' => 'required|string|min:6|confirmed',
            'roles'    => 'required|array',
        ]);
        // إنشاء المستخدم
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        // ربط الدور بالمستخدم
        $user->assignRole($request->input('roles'));
        return redirect('/user')->with('success', 'تم إنشاء المستخدم بنجاح');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            
            'roles' => 'required'
        ]);
        $input = $request->all();


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('user.index')
            ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }
    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->route('user.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
