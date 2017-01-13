<?php

use Illuminate\Database\Seeder;

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
        \App\Models\User::insert($users->toArray());

        $user = \App\Models\User::find(1);
        $user->name = 'weektrip';
        $user->email = 'weektrip@weektrip.cn';
        $user->password = 'lrb39615';
        $user->is_admin = true;
        $user->save();
    }
}
