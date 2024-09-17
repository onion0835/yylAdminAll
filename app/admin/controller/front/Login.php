<?php

namespace app\admin\controller\front;

use app\common\controller\BaseController;
use app\common\validate\system\UserValidate;
use app\common\service\system\SettingService;
use app\common\service\system\LoginService;
use app\common\service\utils\AjCaptchaUtils;
use app\common\service\utils\CaptchaUtils;
use app\common\service\member\MemberService;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("前端登录退出")
 * @Apidoc\Group("front_logout")
 * @Apidoc\Sort("100")
 */
class Login extends BaseController
{
    /**
     * @Apidoc\Title("前端设置信息")
     * @Apidoc\Desc("系统信息")
     * @Apidoc\Method("GET")
     * @Apidoc\Returned(ref="app\common\model\system\SettingModel", field="system_name,page_title,captcha_switch,captcha_mode,captcha_type,login_bg_color,page_limit,is_watermark")
     * @Apidoc\Returned(ref="app\common\service\system\SettingService\info")
     * @Apidoc\NotHeaders()
     * @Apidoc\NotQuerys()
     * @Apidoc\NotParams()
     */
    public function setting()
    {
        $data = SettingService::info('system_name,page_title,logo_url,favicon_url,login_bg_url,captcha_switch,captcha_mode,captcha_type,token_type,token_name,login_bg_color,page_limit,is_watermark');

        $data['captcha_src'] = '';
        if ($data['captcha_switch']) {
            if ($data['captcha_mode'] == 1) {
                $captcha = CaptchaUtils::create($data['captcha_type']);
                $data    = array_merge($data, $captcha);
            }
        }

        return success($data);
    }

    /**
     * @Apidoc\Title("前端验证码")
     * @Apidoc\Desc("get获取验证码，post验证行为验证码")
     * @Apidoc\Method("GET,POST")
     * @Apidoc\Param("captchaType", type="string", require=true, desc="行为，验证码方式：blockPuzzle、clickWord")
     * @Apidoc\Param("pointJson", type="string", default="", desc="行为，pointJson")
     * @Apidoc\Param("token", type="string", default="", desc="行为，token")
     * @Apidoc\Returned(ref="app\common\model\system\SettingModel", field="captcha_switch,captcha_mode,captcha_type")
     * @Apidoc\Returned(ref="captchaReturn")
     * @Apidoc\NotHeaders()
     * @Apidoc\NotQuerys()
     * @Apidoc\NotParams()
     */
    public function captcha()
    {
        $data = SettingService::info('captcha_switch,captcha_mode,captcha_type');

        if ($this->request->isGet()) {
            $data['captcha_src'] = '';
            if ($data['captcha_switch']) {
                if ($data['captcha_mode'] == 2) {
                    ini_set('memory_limit', '512M');
                    $AjCaptchaUtils = new AjCaptchaUtils();
                    $captcha = $AjCaptchaUtils->get($data['captcha_type']);
                    $data = array_merge($data, $captcha);
                } else {
                    $captcha = CaptchaUtils::create($data['captcha_type']);
                    $data = array_merge($data, $captcha);
                }
            }
        } else {
            $captchaData = $this->param('');
            $AjCaptchaUtils = new AjCaptchaUtils();
            $data = $AjCaptchaUtils->check($data['captcha_type'], $captchaData);
        }

        return success($data);
    }

    /**
     * @Apidoc\Title("前端登录")
     * @Apidoc\Method("POST")
     * @Apidoc\Param(ref="app\common\model\system\UserModel", field="username,password")
     * @Apidoc\Param(ref="captchaParam")
     * @Apidoc\Returned(ref="app\common\model\system\UserModel", field="user_id,nickname,username")
     * @Apidoc\Returned("AdminToken", type="string", desc="token")
     * @Apidoc\After(event="setGlobalBody", key="AdminToken", value="res.data.data.AdminToken", desc="AdminToken")
     * @Apidoc\After(event="setGlobalQuery", key="AdminToken", value="res.data.data.AdminToken", desc="AdminToken")
     * @Apidoc\After(event="setGlobalHeader", key="AdminToken", value="res.data.data.AdminToken", desc="AdminToken")
     * @Apidoc\NotHeaders()
     * @Apidoc\NotQuerys()
     * @Apidoc\NotParams()
     */
    public function login()
    {
        // Define the log file path
        $logFile = __DIR__ . '/login.log';

        // Record the login request parameters
        error_log("Login request: " . json_encode($this->request->param()) . "\n", 3, $logFile);
        
        
        $param = $this->params([
            'username/s'     => '',
            'password/s'     => '',
            'captcha_id/s'   => '',
            'captcha_code/s' => '',
            'ajcaptcha',
        ]);

        validate(UserValidate::class)->scene('login')->check($param);

        $setting = SettingService::info();
        if ($setting['captcha_switch']) {
            if ($setting['captcha_mode'] == 2) {
                $AjCaptchaUtils = new AjCaptchaUtils();
                $captcha_check = $AjCaptchaUtils->checkTwo($setting['captcha_type'], $param['ajcaptcha']);
                if ($captcha_check['error']) {
                    return error(lang('system.Verification code error'));
                }
            } else {
                if (empty($param['captcha_code'])) {
                    return error(lang('system.Please enter the verification code'));
                }
                $captcha_check = CaptchaUtils::check($param['captcha_id'], $param['captcha_code']);
                if (empty($captcha_check)) {
                    return error(lang('system.Verification code error'));
                }
            }
        }

        $data = MemberService::login($param);

        return success($data, '登录成功');
    }

    /**
     * @Apidoc\Title("前端退出")
     * @Apidoc\Method("POST")
     * @Apidoc\Before(event="clearGlobalHeader", key="AdminToken")
     * @Apidoc\Before(event="clearGlobalQuery", key="AdminToken")
     * @Apidoc\Before(event="clearGlobalBody", key="AdminToken")
     */
    public function logout()
    {
        $param['user_id'] = user_id();

        validate(UserValidate::class)->scene('info')->check($param);

        $data = LoginService::logout($param['user_id']);

        return success($data, '退出成功');
    }
}