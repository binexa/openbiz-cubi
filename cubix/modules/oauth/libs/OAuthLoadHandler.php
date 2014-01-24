<?php

use Openbiz\Openbiz;
include_once (Openbiz::$app->getModulePath()."/system/lib/ModuleLoadHandler.php");

class OAuthLoadHandler implements ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader)
    {
    }
    
    public function postLoadingModule($moduelLoader)
    {
    	
    	$roleRec = Openbiz::getObject("system.do.RoleDO")->fetchOne("[name]='Cubi Member'");
    	$roleId = $roleRec['Id'];
    	
    	$actionRec = Openbiz::getObject("system.do.AclActionDO")->fetchOne("[module]='oauth' AND [resource]='oauth' AND [action]='MyAccount'");
    	$actionId = $actionRec["Id"];
    	
    	$aclRecord = array(
    		"role_id" =>  $roleId,
    		"action_id" => $actionId,
    		"access_level" => 1
    	);
    	Openbiz::getObject("system.do.AclRoleActionDO")->insertRecord($aclRecord);
    }

}

