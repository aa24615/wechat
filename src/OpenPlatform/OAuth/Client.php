<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\OpenPlatform\OAuth;

use EasyWeChat\Kernel\BaseClient;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;

/**
 * Class Client.
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取网页应用登录链接
     *
     * @see https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Wechat_Login.html
     *
     * @param string $redirect
     * @param string $state
     *
     * @return string
     */
    public function getLoginUrl(string $redirect, string $state = '')
    {
        $state || $state = rand();
        $params = [
            'appid' => $this->app['config']['app_id'],
            'redirect_uri' => $redirect,
            'response_type' => 'code',
            'scope' => 'snsapi_login',
            'state' => $state,
        ];

        return 'https://open.weixin.qq.com/connect/qrconnect?'.http_build_query($params).'#wechat_redirect';
    }


    public function getToken()
    {
        $state || $state = rand();
        $params = [
            'appid' => $this->app['config']['app_id'],
            'redirect_uri' => $redirect,
            'response_type' => 'code',
            'scope' => 'snsapi_login',
            'state' => $state,
        ];

        $this->httpGet("")

        return 'https://open.weixin.qq.com/connect/qrconnect?'.http_build_query($params).'#wechat_redirect';

    }

    /**
     * 获取用户个人信息（UnionID机制）
     *
     * @see https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Authorized_Interface_Calling_UnionID.html
     *
     * @param string $code
     *
     * @return string
     */

    public function getUser(string $code)
    {

    }
}