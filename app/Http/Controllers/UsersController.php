<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class UsersController extends Controller
{
    // 使用身份验证(AUTH)中间件来过滤未登录用户的edit, update动作
    public function __construct()
    {
        $this->middleware('auth', [
            'only'  => ['edit', 'update', 'destroy', 'followings', 'followers']
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
        // 获取微博动态数据
        $statuses = $user->statuses()
            ->orderBy('created_at', 'desc')
            ->paginate(30);
        return view('users.show', compact('user', 'statuses'));
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

        // 激活邮箱发送
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮箱已经发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
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

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'weektrip@weektrip.cn';
        $name = 'WeekTrip';
        $to   = $user->email;
        $subject = '感谢注册 WeekTrip 应用！请确认您的邮箱。';

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
           $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功!');
        return redirect()->route('users.show', [$user]);
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(30);
        $title = '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(30);
        $title = '粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }
}
