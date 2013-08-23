<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.extend.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ExtendSettingForm.php 3360 2012-05-31 06:00:17Z rockyswen@gmail.com $
 */

class ExtendSettingForm extends EasyForm
{
	public $m_ParentFormElementMeta;
	public $m_AccessSelectFrom;		
	
	public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->objectName, "ParentFormElementMeta", $this->m_ParentFormElementMeta);
        return parent::getSessionVars($sessionContext);
    }

    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar($this->objectName, "ParentFormElementMeta", $this->m_ParentFormElementMeta);
        return parent::setSessionVars($sessionContext);       
    }

    public function fetchDataSet()
    {
    	$this->m_AccessSelectFrom = $this->m_ParentFormElementMeta["ATTRIBUTES"]['ACCESSSELECTFROM'];
    	return parent::fetchDataSet();
    }
    
   
}
?>