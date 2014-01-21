<?php 
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   \
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: oauth_callback_handler.php 4032 2012-08-26 06:33:15Z hellojixian@gmail.com $
 */

include_once 'bin/app_init.php';

include_once OPENBIZ_PATH."/bin/ErrorHandler.php";

$type=Openbiz::$app->getClientProxy()->getRequestParam("type");  
$service=Openbiz::$app->getClientProxy()->getRequestParam("service");

$redirectURL=Openbiz::$app->getClientProxy()->getRequestParam("redirect_url");
if($redirectURL)
{
	Openbiz::$app->getSessionContext()->setVar("oauth_redirect_url", $redirectURL);
}

$assocURL	=Openbiz::$app->getClientProxy()->getRequestParam("assoc_url");
if($assocURL)
{
	Openbiz::$app->getSessionContext()->setVar("oauth_assoc_url", $assocURL);
}

//$whitelist_arr=array('qq','sina','alipay','google','facebook','qzone','twitter');
$whitelist_arr = Openbiz::getService(CUBI_LOV_SERVICE)->getDictionary("oauth.lov.ProviderLOV(Provider)");

if(!in_array($type,$whitelist_arr)){
	throw new Exception('Unknown service');
	return;
}
 
$oatuthType=OPENBIZ_APP_MODULE_PATH."/oauth/libs/{$type}.class.php";
if(!file_exists($oatuthType))
{
	throw new Exception('Unknown type');
	return;
}

include_once $oatuthType;
$obj = new $type;
switch(strtolower($service))
{
	case "callback":
	case "login":
		break;
	default:
		throw new Exception('Unknown service');
		break;
}

//call_user_method($service, $obj, "\t");
call_user_func(array($obj,$service));
 