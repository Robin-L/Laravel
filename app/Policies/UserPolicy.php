<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 * @package App\Policies
 *          授权策略类，用户管理用户模型的授权
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $currentUser 默认为当前登录用户实例
     * @param User $user        要进行授权的用户实例
     * @return bool
     * ----------------
     * 1、不需要检查$currentUser是不是NULL，未登录用户，其所有权限返回false
     * 2、调用时，默认情况下，我们 不需要 传递当前登录用户至该方法内，因为框架会自动加载当前登录用户
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
