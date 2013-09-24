<?php 
class AddressPickerForm extends PickerForm
{
	public function fetchData()
	{
		$result = parent::fetchData();
		$prtFormName = BizSystem::getObject($this->parentFormName)->parentFormName;
		if( $prtFormName=='account.form.AccountEditShippingAddressForm' || 
			$prtFormName=='account.form.AccountEditBillingAddressForm'
			){
			$account_id = BizSystem::getObject(BizSystem::getObject($this->parentFormName)->parentFormName)->recordId;
			$result['account_id'] = $account_id;	
			$productRec = BizSystem::getObject("account.do.AccountPickDO")->fetchById($account_id);			
			$result['account_name'] = $productRec['name'];
		}
		return $result;
	}
		
}
?>