<?php

use Openbiz\Openbiz;

require_once Openbiz::$app->getModulePath() . '/websvc/lib/WebsvcService.php';

class callbackService extends WebsvcService
{

    protected $oauthProviderDo = 'oauth.do.OauthProviderDO';

    public function __call($method, $arguments = null)
    {
        $type = Openbiz::$app->getClientProxy()->getRequestParam("type");

        $redirectURL = Openbiz::$app->getClientProxy()->getRequestParam("redirect_url");
        if ($redirectURL) {
            Openbiz::$app->getSessionContext()->setVar("oauth_redirect_url", $redirectURL);
        }

        $assocURL = Openbiz::$app->getClientProxy()->getRequestParam("assoc_url");
        if ($assocURL) {
            Openbiz::$app->getSessionContext()->setVar("oauth_assoc_url", $assocURL);
        }

        // $whitelist_arr = Openbiz::getService(CUBI_LOV_SERVICE)->getDictionary("oauth.lov.ProviderLOV(Provider)");
        $whitelist_arr = Openbiz::getObject($this->oauthProviderDo)->fetchOne("[status]=1 and [type]='{$type}'", 1);
        if ($whitelist_arr) {
            $whitelist_arr = $whitelist_arr->toArray();
        }
        if (!$whitelist_arr && !in_array($type, $whitelist_arr)) {
            throw new Exception('Unknown service');
            return;
        }

        $oatuthType = Openbiz::$app->getModulePath() . "/oauth/libs/{$type}.class.php";
        if (!file_exists($oatuthType)) {
            throw new Exception('Unknown type');
            return;
        }

        include_once $oatuthType;
        $obj = new $type;
        switch (strtolower($method)) {
            case "callback":
            case "login":
                break;
            default:
                throw new Exception('Unknown service');
                break;
        }
        return call_user_func(array($obj, $method));
    }

}
