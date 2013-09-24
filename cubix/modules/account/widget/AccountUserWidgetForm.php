<?php 
class AccountUserWidgetForm extends EasyForm
{
	public $assocDO 	= "account.do.AccountUserDO";
	public $userDO 	= "system.do.UserDO";
	
	public function switchUser($user_id)
	{
		$userRec = BizSystem::getObject("system.do.UserDO")->fetchById($user_id);
		$username = $userRec['username'];
		$serviceObj = BizSystem::getService(PROFILE_SERVICE);

        if (method_exists($serviceObj,'SwitchUserProfile')){
            $serviceObj->SwitchUserProfile($username);
        }        
        $pageURL = OPENBIZ_APP_INDEX_URL.'/mystore/profile';
		BizSystem::clientProxy()->redirectPage($pageURL);   
	}
	
	public function quickadd(){
		
		$username = BizSystem::clientProxy()->getFormInputs("fld_username");
		$perm = BizSystem::clientProxy()->getFormInputs("fld_perm");
		
		//test if username exists in system
		$userRec = BizSystem::getObject($this->userDO)->fetchOne("[username]='$username'");
		if(!$userRec)
		{
			$this->errors = array("fld_username"=>$this->getMessage("USERNAME_DOES_NOT_EXISTS"));
			$this->updateForm();
			return ;
		}
		
		//test if user is already assoicated
		$userId = $userRec['Id'];
		$userRec = BizSystem::getObject($this->assocDO)->fetchOne("[user_id]='$userId'");
		if($userRec)
		{
			$this->errors = array("fld_username"=>$this->getMessage("USER_ALREADY_EXISTS"));
			$this->updateForm();
			return ;
		}
		
		//insert a new assoc record
		$accountId = BizSystem::getObject($this->parentFormName)->recordId;
		$userAssocArr = array(
			"account_id" => $accountId,
			"user_id" => $userId,
			"access_level" => $perm
		);
		BizSystem::getObject($this->assocDO)->insertRecord($userAssocArr);
		$this->updateForm();
		
	}
	
	public function fetchDataSet(){
		$resultSet = parent::fetchDataSet();
		$newResultSet = array();
		$assocDO = BizSystem::getObject($this->assocDO);
		$accountId = BizSystem::getObject($this->parentFormName)->recordId;
		foreach ($resultSet as $key=>$value){
			$userId = $value['Id'];
			$assocRec = $assocDO->fetchOne("[user_id]='$userId' AND [account_id]='$accountId'");
			$value['account_access_level']=$assocRec['access_level'];			
			$value['account_create_time']=$assocRec['create_time'];
			$value['account_status']=$assocRec['status'];
			$newResultSet[$key] = $value;
		}
		return $newResultSet;
	}
}
?>