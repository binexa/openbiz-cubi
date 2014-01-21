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
 * @version   $Id: DataShareGroupList.php 3355 2012-05-31 05:43:33Z rockyswen@gmail.com $
 */

use Openbiz\Openbiz;
use Openbiz\Core\Expression;

class DataShareGroupList extends Listbox
{
    protected function getSelectFrom()
    {
        $formobj = $this->getFormObj();
    	if(!Openbiz::$app->allowUserAccess("data_assign.assign_to_other")){
    		$groups=Openbiz::$app->getUserProfile("groups");
    		if($groups){
    			$ids = implode(",", $groups);
    			$selectFrom = $this->selectFrom . ",[Id] IN ($ids)";
    		}else{
    			$selectFrom = $this->selectFrom;
    		}    		
		}else{
			$selectFrom = $this->selectFrom;
		}
        return Expression::evaluateExpression($selectFrom, $formobj);
    }	
}
