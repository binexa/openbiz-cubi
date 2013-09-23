<?php
/**
 * InputForm class
 *
 * @package 
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
 
include_once "BaseForm.php";
 /*
  * protected methods: validateForm, readInputRecord, readInputs
  */
class InputForm extends BaseForm
{
	//list of method that can directly from browser
	protected $directMethodList = array('saverecord','switchform'); 
	
	public $recordId;
	public $activeRecord;
	
    /**
     * Read user input data from UI
     *
     * @return array - record array
     */
    protected function readInputRecord()
    {
        $recArr = array();
        foreach ($this->dataPanel as $element)
        {
            $value = BizSystem::clientProxy()->getFormInputs($element->objectName);
            if ($value ===null && (
            	   !is_a($element,"FileUploader")
            	&& !is_subclass_of($element,"FileUploader")
            	&& !is_a($element,"Checkbox")    
            	&& !is_a($element,"FormElement")            	
            	)){           
            	continue;
            }
            $element->setValue($value);
            $this->m_FormInputs[$element->objectName] = $value;
            $value = $element->getValue();
            if ( $element->m_FieldName)
                $recArr[$element->m_FieldName] = $value;
        }
		$this->activeRecord = $recArr;
		return $recArr;
    }

    /**
     * Read inputs
     *
     * @return array array of input
     */
    protected function readInputs()
    {
        $inputArr = array();
        foreach ($this->dataPanel as $element)
        {
            $value = BizSystem::clientProxy()->getFormInputs($element->objectName);
            $element->setValue($value);
            $inputArr[$element->objectName] = $value;
        }

        foreach ($this->searchPanel as $element)
        {
            $value = BizSystem::clientProxy()->getFormInputs($element->objectName);
            $element->setValue($value);
            $inputArr[$element->objectName] = $value;
        }
        return $inputArr;
    }
	
	/**
     * Validate input on EasyForm level
     * default form validation do nothing.
     * developers need to override this method to implement their logic
     *
     * @return boolean
     */
    protected function validateForm($cleanError = true)
    {
        if($cleanError == true)
        {
            $this->m_ValidateErrors = array();
        }
        $this->dataPanel->rewind();
        while($this->dataPanel->valid())
        {
            /* @var $element Element */
            $element = $this->dataPanel->current();
            if($element->m_Label)
            {
                $elementName = $element->m_Label;
            }
            else
            {
                $elementName = $element->text;
            }
            if ($element->checkRequired() === true &&
                    ($element->value==null || $element->value == ""))
            {
                $errorMessage = $this->getMessage("FORM_ELEMENT_REQUIRED",array($elementName));
                $this->m_ValidateErrors[$element->objectName] = $errorMessage;
                //return false;
            }
            elseif ($element->value!==null && $element->Validate() == false)
            {
                $validateService = BizSystem::getService(VALIDATE_SERVICE);
                $errorMessage = $this->getMessage("FORM_ELEMENT_INVALID_INPUT",array($elementName,$value,$element->validator));                
                if ($errorMessage == false)
                { //Couldn't get a clear error message so let's try this
                    $errorMessage = $validateService->getErrorMessage($element->validator, $elementName);
                }
                $this->m_ValidateErrors[$element->objectName] = $errorMessage;
                //return false;
            }
            $this->dataPanel->next() ;
        }
        if (count($this->m_ValidateErrors) > 0)
        {
            throw new ValidationException($this->m_ValidateErrors);
            return false;
        }
        return true;
    }
}
?>