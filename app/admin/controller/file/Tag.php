<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller\file;

use app\common\controller\BaseController;
use app\common\validate\file\TagValidate;
use app\common\service\file\TagService;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("文件标签")
 * @Apidoc\Group("file")
 * @Apidoc\Sort("300")
 */
class Tag extends BaseController
{
    /**
     * @Apidoc\Title("文件标签列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="searchQuery")
     * @Apidoc\Query(ref="dateQuery")
     * @Apidoc\Returned(ref="expsReturn")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", ref="app\common\model\file\TagModel", type="array", desc="标签列表", field="tag_id,tag_name,tag_desc,remark,sort,is_disable,create_time,update_time")
     */
    public function list()
    {
        $where = $this->where(where_delete());

        $data = TagService::list($where, $this->page(), $this->limit(), $this->order());

        $data['exps']  = where_exps();
        $data['where'] = $where;

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签信息")
     * @Apidoc\Param(ref="app\common\model\file\TagModel", field="tag_id")
     * @Apidoc\Returned(ref="app\common\model\file\TagModel")
     */
    public function info()
    {
        $param = $this->params(['tag_id/d' => '']);

        validate(TagValidate::class)->scene('info')->check($param);

        $data = TagService::info($param['tag_id']);

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签添加")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\file\TagModel", field="tag_unique,tag_name,tag_desc,remark,sort")
     */
    public function add()
    {
        $param = $this->params(TagService::$edit_field);

        validate(TagValidate::class)->scene('add')->check($param);

        $data = TagService::add($param);

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签修改")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\file\TagModel", field="tag_id,tag_unique,tag_name,tag_desc,remark,sort")
     */
    public function edit()
    {
        $param = $this->params(TagService::$edit_field);

        validate(TagValidate::class)->scene('edit')->check($param);

        $data = TagService::edit($param['tag_id'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签删除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     */
    public function dele()
    {
        $param = $this->params(['ids/a' => []]);

        validate(TagValidate::class)->scene('dele')->check($param);

        $data = TagService::dele($param['ids']);

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签是否禁用")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="idsParam")
     * @Apidoc\Param(ref="app\common\model\file\TagModel", field="is_disable")
     */
    public function disable()
    {
        $param = $this->params(['ids/a' => [], 'is_disable/d' => 0]);

        validate(TagValidate::class)->scene('disable')->check($param);

        $data = TagService::edit($param['ids'], $param);

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签文件列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="app\common\model\file\TagModel", field="tag_id")
     * @Apidoc\Returned(ref="pagingReturn")
     * @Apidoc\Returned("list", type="array", desc="文件列表", children={
     *   @Apidoc\Returned(ref="app\common\model\file\FileModel", field="file_id,group_id,storage,domain,file_type,file_hash,file_name,file_path,file_size,file_ext,sort,is_disable,create_time,update_time,delete_time"),
     *   @Apidoc\Returned(ref="app\common\model\file\FileModel\getGroupNameAttr", field="group_name"),
     *   @Apidoc\Returned(ref="app\common\model\file\FileModel\getTagNamesAttr", field="tag_names"),
     *   @Apidoc\Returned(ref="app\common\model\file\FileModel\getFileTypeNameAttr", field="file_type_name"),
     *   @Apidoc\Returned(ref="app\common\model\file\FileModel\getFileUrlAttr", field="file_url"),
     * })
     */
    public function file()
    {
        $param = $this->params(['tag_id/s' => '']);

        validate(TagValidate::class)->scene('file')->check($param);

        $where = $this->where(where_delete(['tag_ids', 'in', [$param['tag_id']]]));

        $data = TagService::file($where, $this->page(), $this->limit(), $this->order());

        return success($data);
    }

    /**
     * @Apidoc\Title("文件标签文件解除")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("tag_id", type="array", require=true, desc="标签id")
     * @Apidoc\Param("file_ids", type="array", require=false, desc="文件id，为空则解除所有文件")
     */
    public function fileRemove()
    {
        $param = $this->params(['tag_id/a' => [], 'file_ids/a' => []]);

        validate(TagValidate::class)->scene('fileRemove')->check($param);

        $data = TagService::fileRemove($param['tag_id'], $param['file_ids']);

        return success($data);
    }
}
