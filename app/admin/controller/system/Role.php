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
use app\common\validate\system\RoleValidate;
use app\common\service\system\RoleService;
use app\common\service\system\MenuService;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("角色管理")
 * @Apidoc\Group("system")
 * @Apidoc\Sort("200")
 */
class Role extends BaseController
{
    /**
     * @Apidoc\Title("角色列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="searchQuery")
     * @Apidoc\Query(ref="dateQuery")
     * @Apidoc\Returned(ref="expsReturn")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", ref="app\common\model\system\RoleModel", type="array", desc="角色列表", field="role_id,role_name,role_desc,remark,sort,is_disable,create_time,update_time")
     * @Apidoc\Returned("menu", ref="app\common\model\system\MenuModel", type="tree", desc="菜单树形", field="menu_id,menu_pid,menu_name,menu_url,is_unlogin,is_unauth,is_unrate")
     * @Apidoc\Returned(ref="app\common\model\system\RoleModel\getMenuIdsAttr", field="menu_ids")
     */
    public function list()
    {
        $where = $this->where(where_delete());

        $data = RoleService::list($where, $this->page(), $this->limit(), $this->order());
        $menu = MenuService::list('list', [where_delete()], [], 'menu_id,menu_pid,menu_name,menu_url,is_unlogin,is_unauth,is_unrate');

        $data['menu']     = list_to_tree($menu, 'menu_id', 'menu_pid');
        $data['menu_ids'] = array_column($menu, 'menu_id');
        $data['exps']     = where_exps();
        $data['where']    = $where;

        return success($data);
    }

    /**
     * @Apidoc\Title("角色信息")
     * @Apidoc\Query(ref="app\common\model\system\RoleModel", field="role_id")
     * @Apidoc\Returned(ref="app\common\model\system\RoleModel")
     * @Apidoc\Returned(ref="app\common\model\system\RoleModel\getMenuIdsAttr", field="menu_ids")
     */
    public function info()
    {
        $param = $this->params(['role_id/d' => '']);

        validate(RoleValidate::class)->scene('info')->check($param);

        $data = RoleService::info($param['role_id']);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色添加")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel", field="role_name,role_desc,remark,sort")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel\getMenuIdsAttr", field="menu_ids")
     */
    public function add()
    {
        $param = $this->params(RoleService::$edit_field);

        validate(RoleValidate::class)->scene('add')->check($param);

        $data = RoleService::add($param);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色修改")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel", field="role_id,role_name,role_desc,remark,sort")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel\getMenuIdsAttr", field="menu_ids")
     */
    public function edit()
    {
        $param = $this->params(RoleService::$edit_field);

        validate(RoleValidate::class)->scene('edit')->check($param);

        $data = RoleService::edit($param['role_id'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色删除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     */
    public function dele()
    {
        $param = $this->params(['ids/a' => []]);

        validate(RoleValidate::class)->scene('dele')->check($param);

        $data = RoleService::dele($param['ids']);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色修改菜单")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel\getMenuIdsAttr", field="menu_ids")
     */
    public function editmenu()
    {
        $param = $this->params(['ids/a' => [], 'menu_ids/a' => []]);

        validate(RoleValidate::class)->scene('editmenu')->check($param);

        $data = RoleService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色是否禁用")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\system\RoleModel", field="is_disable")
     */
    public function disable()
    {
        $param = $this->params(['ids/a' => [], 'is_disable/d' => 0]);

        validate(RoleValidate::class)->scene('disable')->check($param);

        $data = RoleService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("角色用户列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="app\common\model\system\RoleModel", field="role_id")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", type="array", desc="用户列表", children={
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel", field="user_id,nickname,username,sort,is_super,is_disable,create_time,update_time"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getAvatarUrlAttr", field="avatar_url"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getDeptNamesAttr", field="dept_names"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getPostNamesAttr", field="post_names"),
     *   @Apidoc\Returned(ref="app\common\model\system\UserModel\getRoleNamesAttr", field="role_names"),
     * })
     */
    public function user()
    {
        $param = $this->params(['role_id/d' => '']);

        validate(RoleValidate::class)->scene('user')->check($param);

        $where = $this->where(where_delete(['role_ids', 'in', [$param['role_id']]]));

        $data = RoleService::user($where, $this->page(), $this->limit(), $this->order());

        return success($data);
    }

    /**
     * @Apidoc\Title("角色用户解除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("role_id", type="array", require=true, desc="角色id")
     * @Apidoc\Param("user_ids", type="array", require=false, desc="用户id，为空则解除所有用户")
     */
    public function userRemove()
    {
        $param = $this->params(['role_id/a' => [], 'user_ids/a' => []]);

        validate(RoleValidate::class)->scene('userRemove')->check($param);

        $data = RoleService::userRemove($param['role_id'], $param['user_ids']);

        return success($data);
    }
}
