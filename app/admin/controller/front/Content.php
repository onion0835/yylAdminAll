<?php

namespace app\admin\controller\front;

use app\common\controller\BaseController;
use app\common\service\content\ContentService;
use app\common\service\content\CategoryService;
use app\common\service\content\TagService;
use hg\apidoc\annotation as Apidoc;


class Content extends BaseController
{
    /**
     * @Apidoc\Title("内容列表")
     * @Apidoc\Query(ref="pagingQuery")
     * @Apidoc\Query(ref="sortQuery")
     * @Apidoc\Query(ref="searchQuery")
     * @Apidoc\Query(ref="dateQuery")
     * @Apidoc\Returned(ref="expsReturn")
     * @Apidoc\NotHeaders()
     * @Apidoc\NotQuerys()
     * @Apidoc\NotParams()
     */
    public function list()
    {
        $where = [];
        //判断catagoryid是否存在
        if(isset($this->request->query()['catagory_id'])){
            $where[] = ['category_id','=',$this->request->query()['catagory_id']];
        }
        $data = ContentService::list($where, $this->page(), $this->limit(), $this->order());
        return $this->success($data);
    }
}