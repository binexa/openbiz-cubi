<?php

use Openbiz\Openbiz;
use Openbiz\Object\MetaObject;

class SystemService extends MetaObject
{

    public function getDefaultGroupID()
    {
        $groupRec = Openbiz::getObject("system.do.GroupDO")->fetchOne("[default]='1'", "[Id] DESC");
        if ($groupRec) {
            $Id = $groupRec['Id'];
        }
        return (int) $Id;
    }

    public function getDefaultRoleID()
    {
        $roleRec = Openbiz::getObject("system.do.RoleDO")->fetchOne("[default]='1'", "[Id] DESC");
        if ($roleRec) {
            $Id = $roleRec['Id'];
        }
        return (int) $Id;
    }
}
