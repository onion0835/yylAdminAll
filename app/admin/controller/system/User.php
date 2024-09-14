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
use app\common\validate\system\UserValidate;
use app\common\service\system\UserService;
use app\common\service\system\RoleService;
use app\common\service\system\DeptService;
use app\common\service\system\PostService;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("用户管理")
 * @Apidoc\Group("system")
 * @Apidoc\Sort("500")
 */
class User extends BaseController
{
    /**
     * @Apidoc\Title("用户列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="searchQuery")
     * @Apidoc\Query(ref="dateQuery")
     * @Apidoc\Returned(ref="expsReturn")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", type="array", desc="用户列表", children={
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel", field="user_id,nickname,username,sort,is_super,is_disable,create_time,update_time"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getAvatarUrlAttr", field="avatar_url"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getDeptNamesAttr", field="dept_names"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getPostNamesAttr", field="post_names"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getRoleNamesAttr", field="role_names"),
     * })
     * @Apidoc\Returned("dept", ref="app\common\model\system\DeptModel", type="tree", desc="部门树形", field="dept_id,dept_pid,dept_name")
     * @Apidoc\Returned("post", ref="app\common\model\system\PostModel", type="tree", desc="职位树形", field="post_id,post_pid,post_name")
     * @Apidoc\Returned("role", ref="app\common\model\system\RoleModel", type="array", desc="角色列表", field="role_id,role_name")
     */
    public function list()
    {
        $where = $this->where(where_delete());

        $data = UserService::list($where, $this->page(), $this->limit(), $this->order());

        $data['dept']  = DeptService::list('tree', [where_delete()], [], 'dept_id,dept_pid,dept_name');
        $data['post']  = PostService::list('tree', [where_delete()], [], 'post_id,post_pid,post_name');
        $data['role']  = RoleService::list([where_delete()], 0, 0, [], 'role_id,role_name')['list'] ?? [];
        $data['exps']  = where_exps();
        $data['where'] = $where;

        return success($data);
    }

    /**
     * @Apidoc\Title("用户信息")
     * @Apidoc\Query(ref="app\common\model\system\UserModel", field="user_id")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getAvatarUrlAttr", field="avatar_url")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getDeptIdsAttr", field="dept_ids")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getPostIdsAttr", field="post_ids")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel\getRoleIdsAttr", field="role_ids")
     */
    public function info()
    {
        $param = $this->params(['user_id/d' => '']);

        validate(UserValidate::class)->scene('info')->check($param);

        $data = UserService::info($param['user_id'], true, true);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户添加")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="avatar_id,nickname,username,password,phone,email,remark,sort")
     */
    public function add()
    {
        $param = $this->params(UserService::$edit_field);
        $param['password'] = $this->param('password');

        validate(UserValidate::class)->scene('add')->check($param);

        $data = UserService::add($param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户修改")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="user_id,avatar_id,nickname,username,password,phone,email,remark,sort")
     */
    public function edit()
    {
        $param = $this->params(UserService::$edit_field);

        validate(UserValidate::class)->scene('edit')->check($param);

        $data = UserService::edit($param['user_id'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户删除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     */
    public function dele()
    {
        $param = $this->params(['ids/a' => []]);

        validate(UserValidate::class)->scene('dele')->check($param);

        $data = UserService::dele($param['ids']);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户修改部门")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel\getDeptIdsAttr", field="dept_ids")
     */
    public function editdept()
    {
        $param = $this->params(['ids/a' => [], 'dept_ids/a' => []]);

        validate(UserValidate::class)->scene('editdept')->check($param);

        $data = UserService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户修改职位")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel\getPostIdsAttr", field="post_ids")
     */
    public function editpost()
    {
        $param = $this->params(['ids/a' => [], 'post_ids/a' => []]);

        validate(UserValidate::class)->scene('editpost')->check($param);

        $data = UserService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户修改角色")
     * @Apidoc\Method("GET,POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel\getRoleIdsAttr", field="role_ids")
     */
    public function editrole()
    {
        $param = $this->params(['ids/a' => [], 'role_ids/a' => []]);

        validate(UserValidate::class)->scene('editrole')->check($param);

        $data = UserService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户修改密码")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="password")
     */
    public function repwd()
    {
        $param = $this->params(['ids/a' => [], 'password/s' => '']);

        validate(UserValidate::class)->scene('repwd')->check($param);

        UserService::edit($param['ids'], $param);

        return success();
    }

    /**
     * @Apidoc\Title("用户是否超管")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="is_super")
     */
    public function super()
    {
        $param = $this->params(['ids/a' => [], 'is_super/d' => 0]);

        validate(UserValidate::class)->scene('super')->check($param);

        $data = UserService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("用户是否禁用")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="is_disable")
     */
    public function disable()
    {
        $param = $this->params(['ids/a' => [], 'is_disable/d' => 0]);

        validate(UserValidate::class)->scene('disable')->check($param);

        $data = UserService::edit($param['ids'], $param);

        return success($data);
    }
}
