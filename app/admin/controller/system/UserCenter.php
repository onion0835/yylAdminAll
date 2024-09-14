<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\system;

use app\common\controller\BaseController;
use app\common\validate\system\UserCenterValidate;
use app\common\validate\system\UserLogValidate;
use app\common\service\system\UserCenterService;
use app\common\service\system\UserLogService;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("个人中心")
 * @Apidoc\Group("system")
 * @Apidoc\Sort("800")
 */
class UserCenter extends BaseController
{
    /**
     * @Apidoc\Title("我的信息")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel", withoutField="password")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getAvatarUrlAttr", field="avatar_url")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getDeptIdsAttr", field="dept_ids")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getPostIdsAttr", field="post_ids")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getRoleIdsAttr", field="role_ids")
     * @Apidoc\Returned("menus", type="array", desc="菜单路由")
     * @Apidoc\Returned("roles", type="array", desc="菜单链接（权限标识）")
     */
    public function info()
    {
        $param['user_id'] = user_id(true);

        validate(UserCenterValidate::class)->scene('info')->check($param);

        $data = UserCenterService::info($param['user_id']);
        if ($data['is_delete'] == 1) {
            exception('账号已被删除！');
        }

        return success($data);
    }

    /**
     * @Apidoc\Title("我的信息修改")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="avatar_id,nickname,username,phone,email")
     */
    public function edit()
    {
        $param = $this->params([
            'avatar_id/d' => 0,
            'nickname/s'  => '',
            'username/s'  => '',
            'phone/s'     => '',
            'email/s'     => '',
        ]);
        $param['user_id'] = user_id(true);

        validate(UserCenterValidate::class)->scene('edit')->check($param);

        $data = UserCenterService::edit($param['user_id'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("我的密码修改")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("password_old", type="string", require=true, desc="旧密码")
     * @Apidoc\Param("password_new", type="string", require=true, desc="新密码")
     */
    public function pwd()
    {
        $param = $this->params([
            'password_old/s' => '',
            'password_new/s' => '',
        ]);
        $param['user_id'] = user_id(true);

        validate(UserCenterValidate::class)->scene('pwd')->check($param);

        UserCenterService::pwd($param['user_id'], $param);

        return success();
    }

    /**
     * @Apidoc\Title("我的日志列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="dateQuery")
     * @Apidoc\Returned(ref="expsReturn")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", type="array", desc="日志列表", children={
     *   @Apidoc\Returned(ref="app\common\model\system\UserLogModel"),
     *   @Apidoc\Returned(ref="app\common\model\system\MenuModel", field="menu_name,menu_url")
     * })
     */
    public function log()
    {
        $param['user_id'] = user_id(true);

        validate(UserCenterValidate::class)->scene('log')->check($param);

        $where = $this->where(where_delete(['user_id', '=', $param['user_id']]));

        $data = UserCenterService::log($where, $this->page(), $this->limit(), $this->order());

        $data['exps']  = where_exps();
        $data['where'] = $where;

        return success($data);
    }

    /**
     * @Apidoc\Title("我的日志信息")
     * @Apidoc\Query(ref="app\common\model\system\UserLogModel", field="log_id")
     * @Apidoc\Returned(ref="app\common\model\system\UserLogModel")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel", field="nickname,username")
     * @Apidoc\Returned(ref="app\common\model\system\MenuModel", field="menu_name,menu_url")
     */
    public function logInfo()
    {
        $param   = $this->params(['log_id/d' => '']);
        $user_id = user_id(true);

        validate(UserLogValidate::class)->scene('info')->check($param);

        $data = UserLogService::info($param['log_id']);
        if ($data['user_id'] != $user_id) {
            $data = [];
        }

        return success($data);
    }

    /**
     * @Apidoc\Title("我的日志删除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     */
    public function logDele()
    {
        $param   = $this->params(['ids/a' => []]);
        $user_id = user_id(true);

        validate(UserLogValidate::class)->scene('dele')->check($param);

        $data = UserLogService::dele($param['ids'], false, $user_id);

        return success($data);
    }
}
