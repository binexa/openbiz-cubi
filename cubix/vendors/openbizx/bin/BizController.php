<?PHP

/**
 * PHPOpenBiz Framework
 *
 * This file contain BizController class, the C from MVC of phpOpenBiz framework,
 * and execute it. So bootstrap script simply include this file. For sample of
 * bootstrap script please see controller.php under baseapp/bin
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: BizController.php 5321 2013-03-21 07:20:24Z rockyswen@gmail.com $
 */
// run controller
//
//session_cache_limiter('public');
ob_start();
header('Content-Type: text/html; charset=utf-8');
include_once("sysheader_inc.php");

/**
 * BizController is the class that dispatches client requests to proper objects
 *
 * @package   openbiz.bin
 * @author    Rocky Swen <rocky@phpopenbiz.org>
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @access    public
 */
class BizController
{

    /**
     * BizRequest object, initialized when BizController created
     * @var BizRequest 
     */
    public $request;
    private $_userTimeoutView = OPENBIZ_USER_TIMEOUT_VIEW;
    private $_accessDeniedView = OPENBIZ_ACCESS_DENIED_VIEW;
    private $_securityDeniedView = OPENBIZ_SECURITY_DENIED_VIEW;

    public function __construct()
    {
        $this->request = new BizRequest($this);
    }

    private $_defaultModule = 'user';

    /**
     * Get default URL
     * @return string
     */
    public function getDefaultModule()
    {
        return $this->_defaultModule;
    }

    /**
     * Set default module name.
     * @param string $module new module name
     */
    public function setDefaultModule($module)
    {
        $this->_defaultModule = $module;
    }

    private $_defaultShortView = "LoginView";

    /**
     * Get default view name, without namespace
     * @return type
     */
    public function getDefaultShortView()
    {
        return $this->_defaultShortView;
    }

    /**
     * Set default view
     * @param string $view view name, without namespace
     */
    public function setDefaultShortView($view)
    {
        $this->_defaultShortView = $view;
    }

    private $_defaultUrl;

    /**
     * Get default URL.
     * @return string
     */
    public function getDefaultUrl()
    {
        if (!$this->_defaultUrl) {
            $this->_defaultUrl = 'index.php/' . $this->getDefaultModule() .' /login';
        }
        return $this->_defaultUrl;
    }

    /**
     * Set default URL.
     * @param string $url The url that will be set as default.
     */
    public function setDefaultUrl($url)
    {
        $this->_defaultUrl = $url;
    }

    /**
     * Process Security Filters
     *
     * @return boolean true if success, and false if have error
     */
    public function processSecurityFilters()
    {
        $securityService = BizSystem::getService(SECURITY_SERVICE);
        $securityService->processFilters();
        $err_msg = $securityService->getErrorMessage();
        if ($err_msg) {
            if ($this->_securityDeniedView) {
                $view = $this->_securityDeniedView;
            } else {
                $view = $this->_accessDeniedView;
            }
            $this->renderView($view);
            //BizSystem::clientProxy()->redirectView($view);
            return false;
        }
        return true;
    }

    /**
     * Dispatches client requests to proper objects, print the returned html text.
     *
     * @return void
     */
    public function dispatchRequest()
    {
        BizSystem::clientProxy()->showClientAlert('not hasView');
        
        if (!$this->request->hasInvocation()) {
            //DebugLine::show($this->request->view);
            //DebugLine::show('form' . $this->request->form);
            return $this->_dispatchView();
        } else {
            //echo 'xxxxxxx';
            //DebugLine::show($this->request->view);
            //DebugLine::show('form' . $this->request->form);
            //DebugLine::show($this->request->getScriptFile());

            //BizSystem::clientProxy()->showClientAlert('not hasView');
            
            if ($this->_isSessionTimeout()) {  // show timeout view
                BizSystem::sessionContext()->destroy();
                return BizSystem::clientProxy()->redirectView($this->_userTimeoutView);
            }            
            $this->_dispatchRPC();
        }
    }

    /**
     * Get the parameter from the url
     *
     * @return array parameter array
     */
    private function _getParameters()
    {
        $getKeys = array_keys($_GET);
        $params = null;
        // read parameters "param:name=value"
        foreach ($getKeys as $key) {
            if (substr($key, 0, 6) == "param:") {
                $paramName = substr($key, 6);
                $paramValue = $_GET[$key];
                $params[$paramName] = $paramValue;
            }
        }
        return $params;
    }

    /**
     * Get user profile array. Profile is provided by profileService
     *
     * @return array profile array
     */
    private function _getUserProfile()
    {
        return BizSystem::getUserProfile();
    }

    /**
     * Check if session timed out.
     *
     * @return boolean true - session timed out, false - session alive
     */
    private function _isSessionTimeout()
    {
        return BizSystem::sessionContext()->isTimeout();
    }

    /**
     * Check if the view can be accessed by current user. Call accessService to do the check
     *
     * @param string $viewName view name
     * @return boolean true= allow, false not allow
     */
    private function _canUserAccessView($viewName)
    {
        // load accessService
        $svcobj = BizSystem::getService(ACCESS_SERVICE);
        return $svcobj->allowViewAccess($viewName);
    }

    /**
     * Render a bizview
     *
     * @param string $viewName name of bizview
     * @param string $rule the search rule of a bizform who is not depent on (a subctrl of) another bizform
     * @return void
     */
    public function renderView($viewName, $form = "", $rule = "", $params = null, $hist = "")
    {
        $bizSystem = BizSystem::instance();

        /* @var $viewObj EasyView */
        if ($viewName == "__DynPopup") {
            $viewObj = BizSystem::getObject($viewName);
            $viewObj->render();
            return;
        }

        
        // if previous view is different with the to-be-loaded view,
        // clear the previous session objects
        $prevViewName = $bizSystem->getCurrentViewName();
        $prevViewSet = $bizSystem->getCurrentViewSet();

        // need to set current view before get view object
        $bizSystem->setCurrentViewName($viewName);

        $viewObj = BizSystem::getViewObject($viewName);
        if (!$viewObj) {
            return;
        }
        $viewSet = $viewObj->getViewSet();
        $bizSystem->setCurrentViewSet($viewSet);

        /*
          if ($prevViewSet && $viewSet && $prevViewSet == $viewSet)   // keep prev view session objects if they have same viewset
          BizSystem::sessionContext()->clearSessionObjects(true);
          else
          BizSystem::sessionContext()->clearSessionObjects(false);
         */
        BizSystem::sessionContext()->clearSessionObjects(true);

        
        
        if ($hist == "N") { // clean view history
            $viewObj->cleanViewHistory();
        }
        if ($form != "" && $rule != "") {
            $viewObj->processRule($form, $rule, TRUE);
        }
        if ($params) {
            $viewObj->setParameters($params);
        }
        if (isset($_GET['mode'])) {   // can specify mode of form
            $viewObj->setFormMode($form, $_GET['mode']);
        }
        //DebugLine::show(__METHOD__.__LINE__);
        $viewObj->render();
        //BizController::hidePageLoading();
    }

    /**
     * Invoke the action passed from browser
     *
     * @return HTML content
     */
    protected function invokeRPC()
    {
        $request = $this->request;
        if (!$request->hasInvocation()) {
            return null;
        }

        if (!$request->isValidInvocation()) {
            $invocationType = $request->getInvocationType();
            trigger_error("$invocationType is not a valid invocation", E_USER_ERROR);
            return;
        }
        if ($this->request->isRPCInvokeInvocation()) {
            BizSystem::clientProxy()->setRpcFlag(true);
        }

        //DebugLine::show(__METHOD__ . __LINE__);
        //return;
        $rpcParams = $this->request->getRpcParameters();

        $num_arg = count($rpcParams);
        if ($num_arg < 2) {
            $errmsg = BizSystem::getMessage("SYS_ERROR_RPCARG", array($class));
            trigger_error($errmsg, E_USER_ERROR);
        } else {
            $objName = array_shift($rpcParams);
            $methodName = array_shift($rpcParams);
            return $this->_execRpcMethod($objName, $methodName, $rpcParams);
        }
    }

    private function _execRpcMethod($objName, $methodName, $params)
    {
        //DebugLine::show(__METHOD__ . __LINE__);
        //return;
        $obj = BizSystem::getObject($objName);

        if ($obj) {
            if (method_exists($obj, $methodName)) {
                if (!$this->validateRequest($obj, $methodName)) {
                    $errmsg = BizSystem::getMessage("SYS_ERROR_REQUEST_REJECT", array($obj->objectName, $methodName));
                    trigger_error($errmsg, E_USER_ERROR);
                }
                switch (count($params)) {
                    case 0: $rt_val = $obj->$methodName();
                        break;
                    case 1: $rt_val = $obj->$methodName($params[0]);
                        break;
                    case 2: $rt_val = $obj->$methodName($params[0], $params[1]);
                        break;
                    case 3: $rt_val = $obj->$methodName($params[0], $params[1], $params[2]);
                        break;
                    default: $rt_val = call_user_func_array(array($obj, $methodName), $params);
                }
            } else {
                $errmsg = BizSystem::getMessage("SYS_ERROR_METHODNOTFOUND", array($objName, $methodName));
                trigger_error($errmsg, E_USER_ERROR);
            }
        } else {
            $errmsg = BizSystem::getMessage("SYS_ERROR_CLASSNOTFOUND", array($objName));
            trigger_error($errmsg, E_USER_ERROR);
        }

        $invocationType = $this->request->getInvocationType();
        if ($invocationType == "Invoke") {  // no RPC invoke, page reloaded -> rerender view
            if (BizSystem::clientProxy()->hasOutput()) {
                BizSystem::clientProxy()->printOutput();
            }
        } else if ($invocationType == "RPCInvoke") {  // RPC invoke
            if (BizSystem::clientProxy()->hasOutput()) {
                if ($_REQUEST['jsrs'] == 1) {
                    echo "<html><body><form name=\"jsrs_Form\"><textarea name=\"jsrs_Payload\" id=\"jsrs_Payload\">";
                }
                BizSystem::clientProxy()->printOutput();
                if ($_REQUEST['jsrs'] == 1) {
                    echo "</textarea></form></body></html>";
                }
            } else {
                return $rt_val;
            }
        }
    }

    /**
     * Validate the request from client.
     *
     * @param object $obj the to be called object
     * @param string $methodName the to be called method name
     * @return boolean
     */
    protected function validateRequest($obj, $methodName)
    {
        if (is_a($obj, "EasyForm") || is_a($obj, "BaseForm")) {
            if (!$obj->validateRequest($methodName)) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Dispatch request to view
     */
    private function _dispatchView()
    {                   
        $request = $this->request;
        if (!Resource::getXmlFileWithPath($request->view)) {
            $this->_renderNotFoundView();
            exit;
        }
        if (!$this->_canUserAccessView($request->view)) {  //access denied error
            $this->renderView($this->_accessDeniedView);
        }
        $this->renderView($request->view, $request->form, $request->rule, $request->params, $request->hist);
    }

    private function _renderNotFoundView()
    {
        if (defined('OPENBIZ_NOTFOUND_VIEW')) {
            $request = $this->request;
            $this->renderView(OPENBIZ_NOTFOUND_VIEW, $request->form, $request->rule, $request->params, $request->hist);
        } else {
            /*
             * @todo : throw exception
             */
        }
    }

    /**
     * Dispatch request as RPC (remote procedure call)
     */
    private function _dispatchRPC()
    {
        if ($this->request->hasContainerView()) {
            //DebugLine::show(__METHOD__ . 'hasContainrView : ' . $this->request->getContainerViewName());
            BizSystem::instance()->setCurrentViewName($this->request->getContainerViewName());
        }        
        $retval = $this->invokeRPC();
        print($retval . " "); // why use space on end of data?
        exit();
    }

    /**
     * Goto default view of module
     *
     * @param string $module
     * @todo need to move to front controller
     */
    public function redirectToDefaultModuleView($module)
    {
        $module = strtolower($module);
        $modfile = OPENBIZ_APP_MODULE_PATH . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'mod.xml';
        $xml = simplexml_load_file($modfile);
        $defaultURL = OPENBIZ_APP_INDEX_URL . $xml->Menu->MenuItem['URL'];
        header("Location: $defaultURL");
    }

    /**
     * Goto default view of user
     *
     * @param string $module
     * @todo need to move to front controller
     */
    public function redirectToDefaultUserView($module)
    {
        /** @todo move to front controller/application */
        // options : redirect or renderDefaultView
        // http://localhost/
        $module_name = $DEFAULT_MODULE;
        $view_name = $DEFAULT_VIEW;
        $profile = BizSystem::getUserProfile();
        if ($profile['roleStartpage'][0]) {
            $DEFAULT_URL = OPENBIZ_APP_INDEX_URL . $profile['roleStartpage'][0];
        }
        header("Location: $DEFAULT_URL");
        exit;
    }

    /**
     * Run application
     */
    public function run()
    {        
        $this->onBeforeRun();

        $profile = BizSystem::sessionContext()->getVar("_USER_PROFILE");
        //DebugLine::show(__METHOD__.__LINE__);
        //DebugLine::show(var_dump($profile));
        
        BizSystem::sessionContext();
        if ($this->processSecurityFilters() === true) {
            $this->dispatchRequest();
        }
        $this->onAfterRun();
    }

    public function onBeforeRun()
    {
        /** @todo need to move to before app run event. */
        if (XHPROF && function_exists("xhprof_enable")) {
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
        }
    }

    public function onAfterRun()
    {
        /** @todo need to move to after app run event. */
        if (XHPROF && function_exists("xhprof_disable")) {
            $xhprof_data = xhprof_disable();
            include_once XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
            include_once XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
            $xhprof_runs = new XHProfRuns_Default();
            $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");
            echo "<div style=\"text-align:center\">xhprof id: <a target=\"_target\" href=\"" . XHPROF_URL . "$run_id\">$run_id</a></div>";
        }
    }

}
