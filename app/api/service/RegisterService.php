<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\api\service;

use app\common\service\member\SettingService;
use app\common\service\member\MemberService;
use app\common\service\member\LogService;

/**
 * 注册
 */
class RegisterService
{
    /**
     * 账号注册
     *
     * @param array $param 注册信息
     *
     * @return array
     */
    public static function register($param)
    {
        if (!isset($param['platform'])) {
            $param['platform'] = member_platform();
        }
        if (!isset($param['application'])) {
            $param['application'] = member_application();
        }
        if (empty($param['username'])) {
            $param['username'] = md5(uniqid(mt_rand(), true));
        }
        $data = MemberService::add($param);

        $member_log['member_id']   = $data['member_id'];
        $member_log['platform']    = member_platform();
        $member_log['application'] = member_application();
        LogService::add($member_log, SettingService::LOG_TYPE_REGISTER);

        return $data;
    }
}
