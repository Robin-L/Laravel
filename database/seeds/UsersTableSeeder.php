<?php

use Illuminate\Database\Seeder;
use \App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 创建50个假用户
     */
    public function run()
    {
        $users = factory(\App\Models\User::class)->times(50)->make();
        User::insert($users->toArray());

        $user = User::find(1);
        $user->name     = 'weektrip';
        $user->email    = 'weektrip@weektrip.cn';
        $user->password = 'lrb39615';
        $user->is_admin = true;
        $user->activated= true;
        $user->save();
    }
}
