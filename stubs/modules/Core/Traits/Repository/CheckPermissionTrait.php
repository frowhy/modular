<?php
/**
 * Created by PhpStorm.
 * User: guoliang
 * Date: 2019/3/11
 * Time: 上午10:17
 */

namespace Modules\Core\Traits\Repository;

use App\User;


/**
 * @property \Illuminate\Database\Eloquent\Model model
 */
trait CheckPermissionTrait
{
    /**
     * 检查权限
     *
     * @param \App\User $user
     * @param int $id
     *
     * @return \Modules\Core\Supports\Response
     */
    public function checkPermission(User $user, int $id)
    {
        return $this->model->where(['id' => $id, 'user_id' => $user->id])->exists();
    }
}
