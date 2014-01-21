<?php

/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.user.view
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LogoutView.php 4295 2012-09-25 08:31:58Z hellojixian@gmail.com $
 */

use Openbiz\Openbiz;

class LogoutView extends EasyView
{

    public function __construct(&$xmlArr)
    {
        $this->Logout();
    }

    public function Logout()
    {
        $eventlog = Openbiz::getService(OPENBIZ_EVENTLOG_SERVICE);
        $profile = Openbiz::$app->getUserProfile();
        $logComment = array($profile["username"], $_SERVER['REMOTE_ADDR']);

        $eventlog->log("LOGIN", "MSG_LOGOUT_SUCCESSFUL", $logComment);

        // destroy all data associated with current session:
        Openbiz::$app->getSessionContext()->destroy();

        //clean cookies
        setcookie("SYSTEM_SESSION_USERNAME", null, time() - 100, "/");
        setcookie("SYSTEM_SESSION_PASSWORD", null, time() - 100, "/");

        // Redirect:
        if (isset($_GET['redirect_url'])) {
            $url = $_GET['redirect_url'];
        } else {
            $url = "login";
        }

        header("Location: $url");
    }

}
