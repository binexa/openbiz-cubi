<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: GeneralSettingForm.php 3355 2012-05-31 05:43:33Z rockyswen@gmail.com $
 */

/**
 * Openbiz Cubi 
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   user.form
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: GeneralSettingForm.php 3355 2012-05-31 05:43:33Z rockyswen@gmail.com $
 */



class GeneralSettingForm extends EasyForm
{        
    public function fetchData(){
        if ($this->activeRecord != null)
            return $this->activeRecord;
        
        $dataObj = $this->getDataObj();
        if ($dataObj == null) return;
		
    	QueryStringParam::setBindValues($this->searchRuleBindValues);        
        	
        if ($this->isRefreshData)   $dataObj->resetRules();
        else $dataObj->clearSearchRule();

        if ($this->m_FixSearchRule)
        {
            if ($this->searchRule)
                $searchRule = $this->searchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }

        $dataObj->setSearchRule($searchRule);
        QueryStringParam::setBindValues($this->searchRuleBindValues);        

        $resultRecords = $dataObj->fetch();
        foreach($resultRecords as $record){
        	$settingRecord["_".$record['name']] = $record["value"];
        }
        
        $this->recordId = $resultRecords[0]['Id'];
        $this->setActiveRecord($settingRecord);

        QueryStringParam::ReSet();
        return $settingRecord;    
    }
    
    public function updateRecord()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();

        if (count($recArr) == 0)
            return;

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
		
        // new save logic
        $settingDo = $this->getDataObj();
        
        foreach ($this->dataPanel as $element)
        {
            $value = $recArr[$element->m_FieldName];
            if ($value === null){ 
            	continue;
            } 
            if(substr($element->m_FieldName,0,1)=='_'){
	            $name = substr($element->m_FieldName,1);
            	$recArrParam = array(
            		"name"	  => $name,
            		"value"   => $value,
	            	"section" => $element->m_ElementSet,
	            	"type" 	  => $element->className,	            
	            );
	            //check if its exsit
	            $record = $settingDo->fetchOne("[name]='$name'");
	            if($record){
	            	//update it
	            	$recArrParam["Id"] = $record->Id;
	            	$settingDo->updateRecord($recArrParam,$record->toArray());
	            }else{
	            	//insert it	            	
	            	$settingDo->insertRecord($recArrParam);
	            }
            }
        }
        
               
        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();

    }


}  
?>