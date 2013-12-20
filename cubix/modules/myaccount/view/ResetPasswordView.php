<?php 
class ResetPasswordView extends EasyView
{

	protected  $forceResetPassword = false;
	
    public function loadSessionVars($sessionContext)
    {
        $sessionContext->loadObjVar($this->objectName, "ForceResetPassword", $this->forceResetPassword);        
    }

    public function saveSessionVars($sessionContext)
    {       
        $sessionContext->saveObjVar($this->objectName, "ForceResetPassword", $this->forceResetPassword);
    }	
    
    public function isForceResetPassword()
    {
    	return $this->forceResetPassword;
    }
    
    public function render()
    {
    	if(isset($_GET['force']))
    	{
    		$this->forceResetPassword = true;
    	}else{
    		$this->forceResetPassword = false;
    	}
    	return parent::render();
    }
}
?>