<?php 
include_once(OPENBIZ_APP_MODULE_PATH."/common/lib/fileUtil.php");
include_once(OPENBIZ_APP_MODULE_PATH."/common/lib/httpClient.php");

require_once "LicenseForm.php";


class LicenseInitializeForm extends LicenseForm
{
	public function GoActive()
	{
		$rec = $this->readInputRecord();
		$this->setActiveRecord($rec);
		if($rec['eula']=="0"){
			$this->errors = array("fld_eula"=>'You must agree with the license');
			$this->hasError = true;	
			BizSystem::clientProxy()->setRPCFlag(true);		
			return parent::rerender();
		}
		
		$appInfo = $this->getAppInfo();
		if(!$appInfo){
			$rec['howto_active'] = 'ENTER';
		}
		
		switch(strtoupper($rec['howto_active']))
		{
			case "ENTER":				
				$this->switchForm("common.form.LicenseActiveForm");
				break;
			case "FREETRIAL":
				if($this->getTrailLicense())
				{
					$scriptStr = 'location.reload();';
					BizSystem::clientProxy()->runClientFunction($scriptStr);
				}
				break;
			case "PURCHASE":				
				$url = $appInfo['APP_PURCHASE'];
				BizSystem::clientProxy()->redirectPage($url);
				break;
			case "WEBSITE":				
				$url = $appInfo['APP_WEBSITE'];
				BizSystem::clientProxy()->redirectPage($url);
				break;
		}
	}
	
	public function getTrailLicense()
	{
		$func = $this->moduleName.'_trial_handler';
		$result = $func();		
		return $result;
	}
}
