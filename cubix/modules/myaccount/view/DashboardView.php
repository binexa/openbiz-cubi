<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.myaccount.view
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: DashboardView.php 3365 2012-05-31 06:07:55Z rockyswen@gmail.com $
 */

class DashboardView extends EasyView
{
	private $userWidgetDO = "myaccount.do.UserWidgetDO";	
	
	protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
		$formRefXML = $this->getFormReferences();		
        $this->formRefs = new MetaIterator($formRefXML,"FormReference",$this);
	}
	
	private function getFormReferences()
	{
		$user_id = BizSystem::GetUserProfile("Id");
		$searchRule="[user_id]='$user_id'";
		$do = BizSystem::GetObject($this->userWidgetDO);
		$formRecs = $do->directfetch($searchRule);
		$formRefXML = array();
		foreach($formRecs as $form){
			$formRefXML[] = array(
				"ATTRIBUTES"=>array(
					"NAME"=>$form['widget']
					),
				"VALUE"=>null
			);
		}
		return $formRefXML;
	}
}
?>