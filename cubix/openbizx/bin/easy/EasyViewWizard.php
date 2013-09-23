<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: EasyViewWizard.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

/**
 * EasyViewWizard is the class that controls the wizard forms
 *
 * @package openbiz.bin.easy
 * @author rocky swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class EasyViewWizard extends EasyView
{
    protected $currentStep;
    protected $m_FormStates;    // (formname, visited, committed)
    protected $dropSession = false;
    protected $m_NaviMethod = 'SwitchPage';

    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_NaviMethod = isset($xmlArr["EASYVIEW"]["ATTRIBUTES"]["NAVIMETHOD"]) ? $xmlArr["EASYVIEW"]["ATTRIBUTES"]["NAVIMETHOD"] :'SwitchPage';
    }
    /**
     * Get/Retrieve Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function loadSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->objectName, "FormStates", $this->m_FormStates, true);
        $sessionContext->getObjVar($this->objectName, "CurrentStep", $this->currentStep, true);
    }

    /**
     * Save Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function saveSessionVars($sessionContext)
    {
        if ($this->dropSession){
            $sessionContext->cleanObj($this->objectName, true);
        }else{
            $sessionContext->setObjVar($this->objectName, "FormStates", $this->m_FormStates, true);
            $sessionContext->setObjVar($this->objectName, "CurrentStep", $this->currentStep, true);
        }
        
    }

    /**
     * Initialize all form objects.
     * NOTE: Do not initiate the all forms
     *
     * @return void
     */
    protected function initAllForms()
    {
    }

    /**
     * Process request
     *
     * @return void
     */
    protected function processRequest()
    {
        parent::processRequest();

        $step = $this->getCurrentStep();

        // only display given step form
        $i = 1;
        foreach ($this->m_FormRefs as $formRef)
        {
            if ($i == $step)
                $formRef->display = true;
            else
                $formRef->display = false;
            $i++;
        }
    }
        
    protected function getStepName($step)
    {
		$i = 1;
        foreach ($this->m_FormRefs as $formRef){
            if($i == $step){            	
            	return $formRef->objectName;
            }        	
            $i++;
        }
        return "";
    }
        
    /**
     * Get current step
     *
     * @return number
     */
    public function getCurrentStep()
    {  	if($_GET['step'])
	    {
	    	$this->currentStep=$_GET['step'];
	    	return $this->currentStep;
	    }
    	elseif($this->currentStep)
    	{
    		if($this->currentStep > $this->m_FormRefs->count()){    			            			
    			return $this->m_FormRefs->count();	
    		}else{
    			return $this->currentStep;	
    		}    		
    	}
    	else
    	{
	        $step = isset($_GET['step']) ? $_GET['step'] : 1;
	        $numForms = 0;
	        foreach ($this->m_FormRefs as $formRef)
	            $numForms++;
	
	        if ($step < 1)
	            $step = 1;
	        if ($step > $numForms)
	            $step = $numForms;
	        $this->currentStep = $step;
	        return $step;
    	}
    }

    /**
     * Render step
     *
     * @param number $step
     * @return void
     */
    public function renderStep($step)
    {
    	if($this->currentStep){
    		$currentStep = $this->currentStep;
    	}else{
        	$currentStep = $this->getCurrentStep();
    	}
        if ($currentStep == $step)
            return;            
		switch(strtoupper($this->m_NaviMethod)){
			case "SWITCHFORM":
				$targetForm = $this->getStepName($step);
				$currentForm = $this->getStepName($currentStep);
				$this->currentStep = $step;		
				$formObj = BizSystem::objectFactory()->getObject($currentForm);
				$formObj->switchForm($targetForm);
				break;
				
			case "SWITCHPAGE":
			default:
				$currentURL = BizSystem::getService(OPENBIZ_UTIL_SERVICE)->getViewURL($this->objectName);
		        $url = OPENBIZ_APP_INDEX_URL.'/'.$currentURL.'/step_'.$step;
				BizSystem::clientProxy()->ReDirectPage($url);
				break;
			
		}
    }

    /**
     * Get form inputs
     *
     * @param string $formName
     * @return array
     */
    public function getFormInputs($formName)
    {
        $formObj = BizSystem::objectFactory()->getObject($formName);
        $rec = $formObj->getActiveRecord();
        return $rec;
    }

    /**
     * Set form state
     *
     * @param string $formName form name
     * @param mixed $state state key
     * @param mixed $value
     * @return void
     */
    public function setFormState($formName, $state, $value)
    {
        $this->m_FormStates[$formName][$state] = $value;
    }

    /**
     * Save wizard data of current+previous pages into database or other storage
     *
     * @return void
     */
    public function commit()
    {
        // call all step forms Commit method    	
        foreach ($this->m_FormStates as $formName=>$state)
        {        	
            if ($state['visited'])
            {
                $r = BizSystem::objectFactory()->getObject($formName)->commit();                
                if (!$r)
                {                	                	
                	return false;
                }
            }
        }              
        foreach ($this->m_FormStates as $formName=>$state)
        {
            if ($state['visited'])
            {
                $r = BizSystem::objectFactory()->getObject($formName)->dropSession();
                if (!$r)
                {                	
                    return false;
                }
            }
        }         
        $this->dropSession = true;
        return true;
    }
   
    /**
     * Cancel, clean up the sessions of view and all forms
     *
     * @return void
     */
    public function cancel()
    {
        // call all step forms Cancel method
        if(is_array($this->m_FormStates)){
	        foreach ($this->m_FormStates as $formName=>$state)
	        {
	            if ($state['visited'])
	                BizSystem::objectFactory()->getObject($formName)->cancel();
	        }
        }
        $this->dropSession = true;
    }

    /**
     * Get output attributs
     *
     * @return array
     * @todo need to raname to getOutputAttributs() or getAttributes
     */
    public function outputAttrs()
    {
        $out = parent::outputAttrs();
        $out['step'] = $this->currentStep;
        $out['forms'] = $this->m_FormRefs;
        return $out;
    }

}

?>