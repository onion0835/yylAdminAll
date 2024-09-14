<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\cache\system;

use think\facade\Cache;

/**
 * 部门管理缓存
 */
class DeptCache
{
    // 缓存标签
    public static $tag = 'system_dept';
    // 缓存前缀
    protected static $prefix = 'system_dept:';

    /**
     * 缓存键名
     *
     * @param mixed $id 部门id、key
     * 
     * @return string
     */
    public static function key($id)
    {
        return self::$prefix . $id;
    }

    /**
     * 缓存写入
     *
     * @param mixed $id   部门id、key
     * @param array $info 部门信息
     * @param int   $ttl  有效时间（秒，0永久）
     * 
     * @return bool
     */
    public static function set($id, $info, $ttl = 43200)
    {
        return Cache::tag(self::$tag)->set(self::key($id), $info, $ttl);
    }

    /**
     * 缓存读取
     *
     * @param mixed $id 部门id、key
     * 
     * @return mixed
     */
    public static function get($id)
    {
        return Cache::get(self::key($id));
    }

    /**
     * 缓存删除
     *
     * @param mixed $id 部门id、key
     * 
     * @return bool
     */
    public static function del($id)
    {
        $ids = var_to_array($id);
        foreach ($ids as $v) {
            Cache::delete(self::key($v));
        }
        return true;
    }

    /**
     * 缓存清除
     * 
     * @return bool
     */
    public static function clear()
    {
        return Cache::tag(self::$tag)->clear();
    }
}
