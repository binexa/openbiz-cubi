<?php

use Openbiz\Openbiz;
use Openbiz\Easy\PickerForm;

class AddressPickerForm extends PickerForm
{
	public function fetchData()
	{
		$result = parent::fetchData();
		$prtFormName = Openbiz::getObject($this->parentFormName)->parentFormName;
		if( $prtFormName=='account.form.AccountEditShippingAddressForm' || 
			$prtFormName=='account.form.AccountEditBillingAddressForm'
			){
			$account_id = Openbiz::getObject(Openbiz::getObject($this->parentFormName)->parentFormName)->recordId;
			$result['account_id'] = $account_id;	
			$productRec = Openbiz::getObject("account.do.AccountPickDO")->fetchById($account_id);			
			$result['account_name'] = $productRec['name'];
		}
		return $result;
	}
		
}
