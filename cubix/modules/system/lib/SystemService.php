<?php

use Openbiz\Openbiz;
use Openbiz\Object\MetaObject;

class SystemService extends MetaObject
{
	public function GetDefaultGroupID()
	{
		$groupRec = Openbiz::getObject("system.do.GroupDO")->fetchOne("[default]='1'","[Id] DESC");
		if($groupRec)
		{
			$Id = $groupRec['Id'];
		}		
		return (int)$Id;
	}
	
	public function GetDefaultRoleID()
	{
		$roleRec = Openbiz::getObject("system.do.RoleDO")->fetchOne("[default]='1'","[Id] DESC");
		if($roleRec)
		{
			$Id = $roleRec['Id'];
		}		
		return (int)$Id;
	}
}
