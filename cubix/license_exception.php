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
 * @version   $Id: license_exception.php 5261 2013-01-23 07:00:16Z hellojixian@gmail.com $
 */

function ioncube_event_handler($err_code, $params)
{
	$current_file = $params['current_file'];
	$current_file = str_replace(Openbiz::$app->getModulePath(), "", $current_file);
	preg_match("|[\\\/]?(.*?)[\\\/]{1}|si",$current_file,$matches);
	$moduleName = $matches[1];	
	
	Openbiz::$app->getSessionContext()->setVar("LIC_SOURCE_URL", $_SERVER['REQUEST_URI']);
	Openbiz::$app->getSessionContext()->setVar("LIC_MODULE", $moduleName);
	
	
	$rh_file = Openbiz::$app->getModulePath().DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'register_handler.php';
	$rh_func = false;
	if(is_file($rh_file))
	{
		include_once($rh_file);
		if(function_exists($moduleName."_register_handler")){
			$rh_func = true;
		}
	}
	
	$lic_file = Openbiz::$app->getModulePath().DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'license.key';
	if(!is_file($lic_file) && $rh_func)
	{
		$formObj = Openbiz::getObject("common.form.LicenseInitializeForm");
		$formObj->sourceURL = $_SERVER['REQUEST_URI'];
		$formObj->errorCode = $err_code;
		$formObj->errorParams = $params;		
		$viewObj = Openbiz::getObject("common.view.LicenseInitializeView");
		$viewObj->render();
	}else{
		$formObj = Openbiz::getObject("common.form.LicenseInvalidForm");
		$formObj->sourceURL = $_SERVER['REQUEST_URI'];
		$formObj->errorCode = $err_code;
		$formObj->errorParams = $params;
		$viewObj = Openbiz::getObject("common.view.LicenseInvalidView");
		$viewObj->render();	

	}	
	
	exit;
}

