<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.eventlog.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

use Openbiz\Openbiz;
use Openbiz\I18n\I18n;
use Openbiz\Easy\EasyForm;

/**
 * UserForm class - implement the login of login form
 *
 * @package system.form
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class EventLogForm extends EasyForm
{
	public function fetchDataSet()
    {
		$resultRecords = parent::fetchDataSet();
		for($i=0;$i<count($resultRecords);$i++){
			$rec=$resultRecords->get($i);		
			$rec['event'] = $this->getMessage($resultRecords[$i]['event']);
			$rec['message'] = $this->getMessage($resultRecords[$i]['message'],unserialize($resultRecords[$i]['comment']));	
			$resultRecords->set($i,$rec);			 
		}

		return $resultRecords;
    }

    public function fetchData()
    {
    	$resultRecord = parent::fetchData();
    	$resultRecord['event'] = $this->getMessage($resultRecord['event']);
		$resultRecord['message'] = $this->getMessage($resultRecord['message'],unserialize($resultRecord['comment']));
 		return $resultRecord;
    }    
    public function exportCSV()
    {
		$eventlogSvc = Openbiz::getService(OPENBIZ_EVENTLOG_SERVICE);	
		$eventlogSvc->exportCSV();
		$this->runEventLog();
		return true;    	
    }
    
    public function ClearLog()	
	{
        try
        {
          $this->getDataObj()->deleteRecords();
        } 
        catch (Openbiz\data\Exception $e)
        {
           $this->processDataException($e);
           return;
        }
       
        if (strtoupper($this->formType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}   
	
    public function getMessage($messageId, $params=array())
    {
        $message = isset($this->objectMessages[$messageId]) ? $this->objectMessages[$messageId] : @constant($messageId);
        if (!$message) {
            $message = $messageId;
        }
        else {
            //$message = I18n::getInstance()->translate($message);
            $message = I18n::t($message, $messageId, $this->getModuleName($this->objectName));
        }
        return @vsprintf($message,$params);
    }
}  
