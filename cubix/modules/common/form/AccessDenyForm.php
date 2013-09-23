<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: AccessDenyForm.php 5053 2013-01-05 06:30:02Z hellojixian@gmail.com $
 */

class AccessDenyForm extends EasyForm
{
	public $isDefaultPage = 0;
	
    public function saveSessionVars($sessionContext)
    {
    	$current_url = $this->getUrlAddress();
		$sessionContext->setObjVar("SYSTEM", "LastViewedPage", $current_url);
		parent::saveSessionVars($sessionContext);
    }
    
    public function fetchData()
    {
		$url = $_SERVER['REQUEST_URI'];
		$roleStartpages = BizSystem::getUserProfile("roleStartpage");
		$default_url = OPENBIZ_APP_INDEX_URL.$roleStartpages[0];		
		if($url == $default_url)
		{
			$this->isDefaultPage = 1;
		}else{
			$this->isDefaultPage = 0;
		}
		return parent::fetchData();
    }
    
	function getUrlAddress()
	{
	    /*** check for https is on or not ***/
	    $url = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	    /*** return the full address ***/
	    return $url .'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
}
?>