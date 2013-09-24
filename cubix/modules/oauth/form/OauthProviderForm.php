<?php
class OauthProviderForm extends EasyForm
{
	protected $type;
	protected $m_key;
	protected $m_secret;

	public function testAllProvider()
	{	
		 $do=BizSystem::getObject('oauth.do.OauthProviderDO');
		 $recArr=$do->directFetch ("[status]=1",30);
		 $recArr=$recArr->toArray();
		 if($recArr)
		 {
			$ErrorKey=array();
			foreach($recArr as $key=>$val)
			{	
				$this->type=$val['type'];
				$this->m_key=$val['key'];
				$this->m_secret=$val['value'];
				if(!$this->GetTestOauth())
				{
					$ErrorKey[]=$val['Id'];
				}
			}
		 }
		
		 if($ErrorKey)
		 {
			$where=implode(',',$ErrorKey);
			$do->updateRecords('[status]=0',"[Id] in ($where)"); 
			$this->errors = array("test"=>$this->getMessage("OAUTH_OFF"));
		 }
		 else
		 {
			$this->notices = array("test"=>$this->getMessage("TEST_SUCCESS"));
		 }
		
		$this->rerender();
	}
	
	public function TestProvider($RecType=false)
	{	
		if(!$this->type)
		{
			
			switch(strtoupper($this->formType))
			{
				case "EDIT":
					$Record=$this->readInputRecord();
					break;
				case "DETAIL":
					$Record=$this->fetchData();
					break;
				default:
					$Record=$this->getActiveRecord();
					break;
			}
			$this->type=$Record['type'];
			$this->m_key=$Record['key'];
			$this->m_secret=$Record['value'];
		}
		if(!$Record['Id'])
		{
			$Record['Id'] = $this->recordId;
		}

		if($this->GetTestOauth())
		{
			$this->notices = array("test"=>$this->getMessage("TEST_SUCCESS"));
		}
		else
		{
			$this->errors = array("test"=>$this->getMessage("TEST_FAILURE"));
			$do=BizSystem::getObject('oauth.do.OauthProviderDO');
			$do->updateRecords('[status]=0',"[Id] ={$Record['Id']}"); 

		}
	
		if($RecType)
		{
			if($this->errors)
			{
				//BizSystem::ClientProxy()->showClientAlert($this->getMessage("TEST_FAILURE"));
				$this->updateForm();
				return false;
			}
			else
			{
				return true;
			}	
			
		}
		else
		{
			$this->rerender();
		}
		return true;
	}
	
	public function UpdateRecord(){
		$this->type = BizSystem::ClientProxy()->getFormInputs("fld_type");
		$this->m_key= BizSystem::ClientProxy()->getFormInputs("fld_key");	
		$this->m_secret = BizSystem::ClientProxy()->getFormInputs("fld_value");	
		if($this->TestProvider(true))
		{
			parent::UpdateRecord();
		}
	}
	
	public function GetTestOauth(){

		$oatuthType=OPENBIZ_APP_MODULE_PATH."/oauth/libs/{$this->type}.class.php";
		if(!file_exists($oatuthType))
		{
			return false;
		}
		
		
		//$whitelist_arr=array('qq','sina','alipay','google','facebook');
		$whitelist_arr = BizSystem::getService(CUBI_LOV_SERVICE)->getDictionary("oauth.lov.ProviderLOV(Provider)");
		
		if(!in_array($this->type,$whitelist_arr)){
			throw new Exception('Unknown service');
			return;
		}
		include_once $oatuthType;
		$obj = new $this->type;
		$rec_arr=$obj->test($this->m_key,$this->m_secret);
		if($rec_arr['oauth_token'])
		{
			return true;
		}
		else
		{
			return false;

		}
	}
	
	public function updateFieldValue($id,$fld_name,$value)
	{
		if($fld_name=='fld_status' && $value==1){
			$rec = $this->getDataObj()->fetchById($id);
			if(!$rec['key'] || !$rec['secret'])
			{
				$rec['status'] = $value;
				$rec->save();
				$this->switchForm("oauth.form.OauthProviderEditForm",$id);
				return;
			}
			
		}
		parent::updateFieldValue($id,$fld_name,$value);
	}	
}
?>