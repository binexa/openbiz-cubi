<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.contact.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ContactGrabberListForm.php 3356 2012-05-31 05:47:51Z rockyswen@gmail.com $
 */

use Openbiz\Openbiz;
use Openbiz\Easy\EasyForm;

class ContactGrabberListForm extends EasyForm
{
	public function Reimport($formName)
	{
        $user_id = Openbiz::$app->getUserProfile("Id");		
		$do = $this->getDataObj()->deleteRecords("[user_id]=$user_id");
		$this->switchForm($formName);		
	}
	
	public function SelectAll()
	{
		$user_id = Openbiz::$app->getUserProfile("Id");		
		$do = $this->getDataObj()->updateRecords("[selected]='1'","[user_id]=$user_id");
		$this->updateForm();
	}
	
	public function UnSelectAll()
	{
		$user_id = Openbiz::$app->getUserProfile("Id");		
		$do = $this->getDataObj()->updateRecords("[selected]='0'","[user_id]=$user_id");
		$this->updateForm();
	}
	
	public function SelectRecord($contact_id=null)
	{
		parent::SelectRecord($contact_id);
		
		if(!$contact_id){
			$contact_id = $this->recordId;
		}
		
		$user_id = Openbiz::$app->getUserProfile("Id");		
		$do = $this->getDataObj();
		$contactRec = $do->fetchById($contact_id);
		switch($contactRec['selected'])
		{
			case '0':
				$selection = 1;
				break;
			case '1':
				$selection = 0;
				break;				
		}
		
		$do->updateRecords("[selected]='$selection'","[Id]='$contact_id' AND [user_id]=$user_id");
		$this->updateForm();	
	}
}
