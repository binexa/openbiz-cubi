<?php 
class MyProfileView extends EasyView
{
	protected  $m_ForceCompeleteProfile = false;
	

    public function loadSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->objectName, "ForceCompeleteProfile", $this->m_ForceCompeleteProfile);        
    }

    public function saveSessionVars($sessionContext)
    {       
        $sessionContext->setObjVar($this->objectName, "ForceCompeleteProfile", $this->m_ForceCompeleteProfile);
    }	
    
    public function isForceCompeleteProfile()
    {
    	return $this->m_ForceCompeleteProfile;
    }
    
    public function render()
    {
    	if(isset($_GET['force']))
    	{
    		$this->m_ForceCompeleteProfile = true;
    	}else{
    		$this->m_ForceCompeleteProfile = false;
    	}
    	    	 
    	if($this->isForceCompeleteProfile())
    	{
			//var_dump($this->m_FormRefs);
			$formRefArr = array(
				"ATTRIBUTES" => array(
					"NAME" => 'myaccount.form.ProfileEditForm'
				),
				"VALUE" => null
			);
			$this->m_FormRefs = new MetaIterator($formRefArr,"FormReference",$this);    
    	}
    	 
    	return parent::render();
    }
}
?>