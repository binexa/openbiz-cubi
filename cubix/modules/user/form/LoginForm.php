<?php

/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.user.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LoginForm.php 4931 2012-12-26 15:41:56Z hellojixian@gmail.com $
 */

use Openbiz\Openbiz;
use Openbiz\Data\DataRecord;
use Openbiz\Easy\EasyForm;

/**
 * LoginForm class - implement the logic of login form
 *
 * @package user.form
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class LoginForm extends EasyForm
{

    protected $username;
    protected $password;
    protected $smartcard;
    protected $lastViewedPage;
    public $auth_method;

    protected function readMetadata(&$xmlArr)
    {
        $do = Openbiz::getObject("myaccount.do.PreferenceDO");
        $rs = $do->directFetch("[user_id]='0' AND ([section]='Login' OR [section]='Register' )");

        if ($rs) {
            foreach ($rs as $item) {
                $preference[$item["name"]] = $item["value"];
            }
        }

        if ($preference['smartcard_auth'] == 1) {
            $this->auth_method = "smartcard";
        }

        $elem_count = count($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"]);
        for ($i = 0; $i < $elem_count; $i++) {
            switch ($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]['ATTRIBUTES']['NAME']) {
                case "antispam":
                    if ($preference['anti_spam'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;

                case "session_timeout":
                    if ($preference['keep_cookies'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;

                case "current_language":
                    if ($preference['language_selector'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;

                case "current_theme":
                    if ($preference['theme_selector'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;
                case "register_new":
                    if ($preference['open_register'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;

                case "forget_pass":
                    if ($preference['find_password'] == 0) {
                        unset($xmlArr["EASYFORM"]["DATAPANEL"]["ELEMENT"][$i]);
                    }
                    break;
            }
        }
        $result = parent::readMetaData($xmlArr);
        return $result;
    }

    public function loadStatefullVars($sessionContext)
    {
        $sessionContext->loadObjVar("SYSTEM", "LastViewedPage", $this->lastViewedPage);
        parent::loadStatefullVars($sessionContext);
    }

    public function fetchData()
    {
        if (isset($_COOKIE["SYSTEM_SESSION_USERNAME"]) && isset($_COOKIE["SYSTEM_SESSION_PASSWORD"])) {
            $this->username = $_COOKIE["SYSTEM_SESSION_USERNAME"];
            $this->password = $_COOKIE["SYSTEM_SESSION_PASSWORD"];

            $svcobj = Openbiz::getService(AUTH_SERVICE);
            $eventlog = Openbiz::getService(OPENBIZ_EVENTLOG_SERVICE);
            if ($svcobj->authenticateUserByCookies($this->username, $this->password)) {
                // after authenticate user: 1. init profile
                $profile = Openbiz::$app->InitUserProfile($this->username);

                // after authenticate user: 2. insert login event
                $logComment = array($this->username, $_SERVER['REMOTE_ADDR']);
                $eventlog->log("LOGIN", "MSG_LOGIN_SUCCESSFUL", $logComment);

                // after authenticate user: 3. update login time in user record
                if (!$this->UpdateloginTime()) {
                    return false;
                }
                if ($profile['roleStartpage'][0]) {
                    $redirectPage = OPENBIZ_APP_INDEX_URL . $profile['roleStartpage'][0];
                    Openbiz::$app->getClientProxy()->ReDirectPage($redirectPage);
                } else {
                    parent::processPostAction();
                }
                return;
            }
        } elseif (Openbiz::$app->getUserProfile("Id")) {
            $profile = Openbiz::$app->getUserProfile();
            $redirectPage = OPENBIZ_APP_INDEX_URL . $profile['roleStartpage'][0];
            echo __METHOD__ . '--' . __LINE__ . '--' . $redirectPage;
            exit;
            Openbiz::$app->getClientProxy()->ReDirectPage($redirectPage);
        }
    }

    /**
     * this method will be called by Mobile Client
     */
    public function ClientLogin()
    {
        echo "got it ";
        exit;
    }

    /**
     * login action
     *
     * @return void
     */
    public function Login()
    {
        $this->readInputRecord();
        try {
            $this->validateForm();
        } catch (Openbiz\validation\Exception $e) {
            DebugLine::show(__METHOD__ . __LINE__);
            $this->processFormObjError($e->errors);
            return;
        }

        

        // get the username and password
        $this->username = Openbiz::$app->getClientProxy()->getFormInputs("username");
        $this->password = Openbiz::$app->getClientProxy()->getFormInputs("password");
        $this->smartcard = Openbiz::$app->getClientProxy()->getFormInputs("smartcard");

        
        
        if ($this->username == $this->getElement("username")->hint) {
            $this->username = null;
        }
        if ($this->password == $this->getElement("password")->hint) {
            $this->password = null;
        }

        $eventlog = Openbiz::getService(OPENBIZ_EVENTLOG_SERVICE);

        try {

            $authUser = $this->authUser();
            if ($authUser) {
                
                // after authenticate user: 1. init profile
                $profile = Openbiz::$app->initUserProfile($this->username);
                                
                //DebugLine::show(var_dump($profile));
                // after authenticate user: 2. insert login event
                $logComment = array($this->username, $_SERVER['REMOTE_ADDR']);
                $eventlog->log("LOGIN", "MSG_LOGIN_SUCCESSFUL", $logComment);

                // after authenticate user: 3. update login time in user record
                if (!$this->updateloginTime()) {
                    return false;
                }

                // after authenticate user: 3. update current theme and language
                $this->updateLanguage();

                $this->updateTheme();

               
                $redirectPage = OPENBIZ_APP_INDEX_URL . $profile['roleStartpage'][0];

                if (!$profile['roleStartpage'][0]) {
                    $errorMessage['password'] = $this->getMessage("PERM_INCORRECT");
                    $errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");
                    $this->processFormObjError($errorMessage);
                    return;
                }

                
                
                $cookies = Openbiz::$app->getClientProxy()->getFormInputs("session_timeout");
                if ($cookies) {
                    $password = $this->password;
                    $password = md5(md5($password . $this->username) . md5($profile['create_time']));
                    setcookie("SYSTEM_SESSION_USERNAME", $this->username, time() + (int) $cookies, "/");
                    setcookie("SYSTEM_SESSION_PASSWORD", $password, time() + (int) $cookies, "/");
                }

                //if its admin first time login, then show init system wizard
                $initLock = OPENBIZ_APP_PATH . '/files/initialize.lock';
                if ($profile['Id'] == 1 && !is_file($initLock)) {
                    $redirectPage = OPENBIZ_APP_INDEX_URL . "/system/initialize";
                    Openbiz::$app->getClientProxy()->ReDirectPage($redirectPage);
                    return true;
                }

                //if admin is not init profile yet
                $initLock = OPENBIZ_APP_PATH . '/files/initialize_profile.lock';
                if ($profile['Id'] == 1 && !is_file($initLock)) {
                    $redirectPage = OPENBIZ_APP_INDEX_URL . "/system/initialize_profile";
                    Openbiz::$app->getClientProxy()->ReDirectPage($redirectPage);
                    return true;
                }

                $profile = Openbiz::$app->getSessionContext()->getVar("_USER_PROFILE");

                if ($this->lastViewedPage != "") {
                    Openbiz::$app->getClientProxy()->redirectPage($this->lastViewedPage);
                } elseif ($profile['roleStartpage'][0]) {
                    Openbiz::$app->getClientProxy()->redirectPage($redirectPage);
                } else {
                    parent::processPostAction();
                }
                return true;
            } else {

                switch ($this->auth_method) {
                    case "smartcard":
                        $logComment = array($this->smartcard);
                        $eventlog->log("LOGIN", "MSG_SMARTCARD_LOGIN_FAILED", $logComment);
                        $errorMessage['smartcard'] = $this->getMessage("SMARTCARD_INCORRECT");
                        break;
                    default:
                        $logComment = array($this->username,
                            $_SERVER['REMOTE_ADDR'],
                            $this->password);
                        $eventlog->log("LOGIN", "MSG_LOGIN_FAILED", $logComment);
                        $errorMessage['password'] = $this->getMessage("PASSWORD_INCORRECT");
                        break;
                }
                $errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");
                $this->processFormObjError($errorMessage);
            }
        } catch (Exception $e) {
            $errorMessage['login_status'] = $this->getMessage("LOGIN_FAILED");
            $this->processFormObjError($errorMessage);
            //Openbiz::$app->getClientProxy()->showErrorMessage($e->getMessage());
        }
    }

    protected function authUser()
    {
        $authService = Openbiz::getService(AUTH_SERVICE);
        switch ($this->auth_method) {
            case "smartcard":
                $result = $authService->authenticateUserBySmartCard($this->smartcard);
                if ($result != false) {
                    $this->username = $result;
                    $result = true;
                }
                break;
            default:
                $result = $authService->authenticateUser($this->username, $this->password);
                break;
        }
        return $result;
    }

    /**
     * Update login time
     *
     * @return void
     */
    protected function UpdateloginTime()
    {
        $userObj = Openbiz::getObject('system.do.UserDO');
        try {
            $curRecs = $userObj->directFetch("[username]='" . $this->username . "'", 1);
            if (count($curRecs) == 0) {
                return false;
            }
            $dataRec = new DataRecord($curRecs[0], $userObj);
            $dataRec['lastlogin'] = date("Y-m-d H:i:s");
            $ok = $dataRec->save();
            if (!$ok) {
                $errorMsg = $userObj->getErrorMessage();
                Openbiz::$app->getLog()->log(LOG_ERR, "DATAOBJ", "DataObj error = " . $errorMsg);
                Openbiz::$app->getClientProxy()->showErrorMessage($errorMsg);
                return false;
            }
        } catch (Openbiz\data\Exception $e) {
            $errorMsg = $e->getMessage();
            Openbiz::$app->getLog()->log(LOG_ERR, "DATAOBJ", "DataObj error = " . $errorMsg);
            Openbiz::$app->getClientProxy()->showErrorMessage($errorMsg);
            return false;
        }
        return true;
    }

    public function ChangeLanguage()
    {
        $currentLanguage = Openbiz::$app->getClientProxy()->getFormInputs("current_language");
        if ($currentLanguage != '') {
            if ($currentLanguage == 'user_default') {
                $currentTheme = OPENBIZ_DEFAULT_LANGUAGE;
            } else {
                Openbiz::$app->getSessionContext()->setVar("LANG", $currentLanguage);
                $this->notices[] = "<script>window.location.reload()</script>";
                $this->UpdateForm();
            }
        }
        return;
    }

    public function ChangeTheme()
    {
        $currentTheme = Openbiz::$app->getClientProxy()->getFormInputs("current_theme");
        if ($currentTheme != '') {
            if ($currentTheme == 'user_default') {
                $currentTheme = CUBI_DEFAULT_THEME_NAME;
            } else {
                Openbiz::$app->getSessionContext()->setVar("THEME", $currentTheme);
                $recArr = $this->readInputRecord();
                $this->setActiveRecord($recArr);
                $this->notices[] = "<script>window.location.reload()</script>";
                $this->UpdateForm();
            }
        }
        return;
    }

    /**
     * Update language that selected by user
     */
    protected function updateLanguage()
    {
        $currentLanguage = Openbiz::$app->getClientProxy()->getFormInputs("current_language");
        if ($currentLanguage != '') {
            if ($currentLanguage == 'user_default') {
                $currentLanguage = OPENBIZ_DEFAULT_LANGUAGE;
            } else {
                Openbiz::$app->getSessionContext()->setVar("LANG", $currentLanguage);
            }
        }
    }

    protected function updateTheme()
    {
        $currentTheme = Openbiz::$app->getClientProxy()->getFormInputs("current_theme");
        if ($currentTheme != '') {
            if ($currentTheme == 'user_default') {
                $currentTheme = CUBI_DEFAULT_THEME_NAME;
            } else {
                Openbiz::$app->getSessionContext()->setVar("THEME", $currentTheme);
            }
        }
    }

}
