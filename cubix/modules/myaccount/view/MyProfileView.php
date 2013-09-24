<?php 
class MyProfileView extends EasyView
{
	protected  $forceCompeleteProfile = false;
	

    public function loadSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->objectName, "ForceCompeleteProfile", $this->forceCompeleteProfile);        
    }

    public function saveSessionVars($sessionContext)
    {       
        $sessionContext->setObjVar($this->objectName, "ForceCompeleteProfile", $this->forceCompeleteProfile);
    }	
    
    public function isForceCompeleteProfile()
    {
    	return $this->forceCompeleteProfile;
    }
    
    public function render()
    {
    	if(isset($_GET['force']))
    	{
    		$this->forceCompeleteProfile = true;
    	}else{
    		$this->forceCompeleteProfile = false;
    	}
    	    	 
    	if($this->isForceCompeleteProfile())
    	{
			//var_dump($this->formRefs);
			$formRefArr = array(
				"ATTRIBUTES" => array(
					"NAME" => 'myaccount.form.ProfileEditForm'
				),
				"VALUE" => null
			);
			$this->formRefs = new MetaIterator($formRefArr,"FormReference",$this);    
    	}
    	 
    	return parent::render();
    }
}
?>