<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.element
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: ShareDataFilter.php 3355 2012-05-31 05:43:33Z rockyswen@gmail.com $
 */

use Openbiz\Openbiz;
use Openbiz\Easy\Element\DropDownList;

class ShareDataFilter extends DropDownList
{
	public function getSearchRule()
	{
		$value = Openbiz::$app->getClientProxy()->getFormInputs($this->objectName);
		$searchRule = "";
		$my_user_id = Openbiz::$app->getUserProfile("Id");
		$user_groups = Openbiz::$app->getUserProfile('groups');
		
		if(count($user_groups)){			
			$group_id_range = implode(",",$user_groups);			
			$group_where = "  ( [group_id] IN ($group_id_range ) )";
		}
		
		if(count($user_groups)){								
			$group_id_range = implode(",",$user_groups);			
			$other_where = "  ( [group_id] NOT IN ($group_id_range ) )";
		}
		
		switch((int)$value){
			case 1:
				if($this->_hasOwnerField()){
					$searchRule = "([create_by]= '$my_user_id' OR [owner_id]='$my_user_id')";
				}
				else{
					$searchRule = "([create_by]= '$my_user_id')";					
				}
				break;
			case 2:
				$searchRule = "($group_where and [create_by]!= '$my_user_id')";
				break;
			case 3:
				$searchRule = "($other_where and [create_by] != '$my_user_id' )";
				break;
			case 4:
				$searchRule = "([create_by]= '$my_user_id')";
				break;
			case 5:
				$searchRule = "([create_by] != '$my_user_id' AND [owner_id]  = '$my_user_id' )";
				break;
			case 6:
				$searchRule = "([create_by]  = '$my_user_id' AND [owner_id] != '$my_user_id' )";
				break;
			
		}

		return $searchRule;        
	}
	
	private function _hasOwnerField(){
		$field = $this->getFormObj()->getDataObj()->getField('owner_id');
		if($field){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	protected function getList(){
    	$list= parent::getList();
    	if(!$this->_hasOwnerField()){
    		unset($list[3]);
    		unset($list[4]);
    		unset($list[5]);
    	}
    	return $list;
    }
}
