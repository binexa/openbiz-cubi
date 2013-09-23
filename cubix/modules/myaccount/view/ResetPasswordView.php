<?php 
class ResetPasswordView extends EasyView
{

	protected  $m_ForceResetPassword = false;
	
    public function loadSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->objectName, "ForceResetPassword", $this->m_ForceResetPassword);        
    }

    public function saveSessionVars($sessionContext)
    {       
        $sessionContext->setObjVar($this->objectName, "ForceResetPassword", $this->m_ForceResetPassword);
    }	
    
    public function isForceResetPassword()
    {
    	return $this->m_ForceResetPassword;
    }
    
    public function render()
    {
    	if(isset($_GET['force']))
    	{
    		$this->m_ForceResetPassword = true;
    	}else{
    		$this->m_ForceResetPassword = false;
    	}
    	return parent::render();
    }
}
?>