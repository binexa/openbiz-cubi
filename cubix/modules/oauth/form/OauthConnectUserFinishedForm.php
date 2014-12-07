<?php

use Openbiz\Openbiz;
use Openbiz\Easy\EasyForm;

class OauthConnectUserFinishedForm extends EasyForm
{

    public $backURL;

    public function fetchData()
    {
        $oauth_data = Openbiz::$app->getSessionContext()->getVar('_OauthUserInfo');
        $record['oauth_data'] = $oauth_data;
        $record['oauth_user'] = $oauth_data['uname'];
        $record['oauth_location'] = $oauth_data['location'];

        $record['local_user'] = Openbiz::$app->getUserProfile("username");
        $record['local_email'] = Openbiz::$app->getUserProfile("email");

        $redirectURL = Openbiz::$app->getSessionContext()->getVar("oauth_redirect_url");
        if ($redirectURL) {
            $this->backURL = $redirectURL;
        } else {
            //$this->backURL = OPENBIZ_APP_INDEX_URL.'/myaccount/my_social_account';
            $this->backURL = OPENBIZ_APP_INDEX_URL;
        }
        return $record;
    }

}
