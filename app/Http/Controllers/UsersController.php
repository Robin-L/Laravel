<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    // 使用身份验证(AUTH)中间件来过滤未登录用户的edit, update动作
    public function __construct()
    {
        $this->middleware('auth', [
            'only'  => ['edit', 'update', 'destroy']
        ]);
        $this->middleware('guest', [
            'only' => ['create'] // 只让未登录的用户访问注册页面
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:50',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => $request->password,
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程！');
        return redirect()->route('users.show', [$user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:50',
            'password'  => 'confirmed|min:6'
        ]);

        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $data = array_filter([
            'name'  => $request->name,
            'password' => $request->password,
        ]);

        $user->update($data);
        session()->flash('success', '个人资料更新成功');
        return redirect()->route('users.show', $id);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
