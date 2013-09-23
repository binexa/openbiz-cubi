<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.application.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ApplicationsListForm.php 4708 2012-11-13 05:27:07Z hellojixian@gmail.com $
 */

include_once 'AppListForm.php';
class ApplicationsListForm extends AppListForm
{
	protected $m_MarketInstalledDO = "market.installed.do.InstalledDO";
	
	public function fetchDataSet()
	{
		parent::fetchDataSet();				
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultSet = array();
				
		$repo_uri = $this->getDefaultRepoURI();	
				
		$params=array(
			"searchRule" => $this->m_RemoteSearchRule,	
			"sortRule" => $this->sortRule,			
			"startItem" => ($this->currentPage-1)*$this->m_Range,
			"range" => $this->m_Range,
		);
		
		$appList = $svc->discoverApplication($repo_uri,$cat_id,$params);	
		if(is_array($appList['data'])){
			foreach($appList['data'] as $appInfo)
			{
				$appInfo['icon'] = $repo_uri.$appInfo['icon'];
				$resultSet[] = $appInfo;
			}
		}		
        $this->totalRecords = $appList['totalRecords'];
        if ($this->m_Range && $this->m_Range > 0)
            $this->totalPages = ceil($this->totalRecords/$this->m_Range);
		
		return $resultSet;
	}
	
	public function isNeedCleanup()
	{
		$searchRule = "[app_id]=0 OR [install_state]!='OK'";
		return BizSystem::getObject($this->m_MarketInstalledDO)->directFetch($searchRule)->count();		
	}
	
	public function Cleanup()
	{
		$searchRule = "[app_id]=0 OR [install_state]!='OK'";
		BizSystem::getObject($this->m_MarketInstalledDO)->deleteRecords($searchRule);
		$this->m_Notices = array(
			"cleanup"=>$this->getMessage("MSG_CLEANUP")
		);
		$this->rerender();
	}
}
?>