<?php

use Openbiz\Openbiz;

include_once('_OAuth/oauth.php');
include_once('_OAuth/WeiboOAuth.php');
require_once "oauth.class.php";
include_once( 'qq/txwboauth.php' );

class qq extends oauthClass
{

    protected $type = 'qq';
    protected $loginUrl;
    private $akey;
    private $skey;

    public function __construct()
    {
        parent::__construct();
        $recArr = $this->getProviderList();
        $this->akey = $recArr['key'];
        $this->skey = $recArr['value'];
    }

    function login()
    {
        $redirectPage = $this->getUrl($this->callBack);
        Openbiz::$app->getClientProxy()->ReDirectPage($redirectPage);
    }

    function test($akey, $skey)
    {
        $o = new QqWeiboOAuth($akey, $skey);
        return $o->getRequestToken($this->callBack);
    }

    function callback()
    {
        $keys = Openbiz::$app->getSessionContext()->getVar('qq_keys');
        $this->checkUser($keys['oauth_token'], $keys['oauth_token_secret']);
        $userInfo = $this->userInfo();
        $this->check($userInfo);
    }

    function getUrl($call_back)
    {
        if (empty($this->akey) || empty($this->skey)) {
            throw new Exception('Unknown qq_akey');
            return false;
        }
        $o = new QqWeiboOAuth($this->akey, $this->skey);

        $keys = $o->getRequestToken($call_back);



        // QQ 返回的oauth_token 的键名有问题，在此临时修正
        $_temp['oauth_token'] = array_shift($keys);
        $keys = array_merge($_temp, $keys);

        $this->loginUrl = $o->getAuthorizeURL($keys['oauth_token'], false, $call_back);
        $this->loginUrl .= '&oauth_token_secret=' . $keys['oauth_token_secret'];
        ;
        Openbiz::$app->getSessionContext()->setVar('qq_keys', $keys);
        //$_SESSION['qq']['keys'] = $keys;
        return $this->loginUrl;
    }

    //用户资料
    function userInfo()
    {
        $me = $this->doClient()->verify_credentials();
        $user['id'] = $me['data']['name'];
        $user['type'] = $this->type;
        $user['email'] = $me['data']['email'];
        $user['uname'] = $me['data']['nick'];
        $user['province'] = $me['data']['province_code'];
        $user['city'] = $me['data']['city_code'];
        $user['location'] = $me['data']['location'];
        $user['userface'] = $me['data']['head'] . "/120";
        $user['sex'] = ($me['data']['sex'] == '1') ? 1 : 0;

        return $user;
    }

    private function doClient($opt = '')
    {
        $tokens = Openbiz::$app->getSessionContext()->getVar('qq_access_token');
        $oauth_token = ( $opt['oauth_token'] ) ? $opt['oauth_token'] : $tokens['oauth_token'];
        $oauth_token_secret = ( $opt['oauth_token_secret'] ) ? $opt['oauth_token_secret'] : $tokens['oauth_token_secret'];
        return new QqWeiboClient($this->akey, $this->skey, $oauth_token, $oauth_token_secret);
    }

    function user($opt)
    {
        return $this->doClient($opt)->user_info();
    }

    //验证用户
    function checkUser($oauth_token, $oauth_token_secret)
    {

        $o = new QqWeiboOAuth($this->akey, $this->skey, $oauth_token, $oauth_token_secret);
        $access_token = $o->getAccessToken($_REQUEST['oauth_verifier']);
        //$_SESSION['qq']['access_token'] = $access_token;
        Openbiz::$app->getSessionContext()->setVar('qq_access_token', $access_token);
    }

    //发布一条微博
    function update($text, $opt)
    {
        return $this->doClient($opt)->t_add($text);
    }

    //上传一个照片，并发布一条微博
    function upload($text, $opt, $pic)
    {
        if (file_exists($pic)) {
            return $this->doClient($opt)->t_add_pic($text, $pic);
        } else {
            return $this->doClient($opt)->t_add($text);
        }
    }

}
