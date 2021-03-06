<?php

/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.extend.element
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: AccessList.php 3360 2012-05-31 06:00:17Z rockyswen@gmail.com $
 */
use Openbiz\Openbiz;
use Openbiz\I18n\I18n;
use Openbiz\Easy\Element\Listbox;

class AccessList extends Listbox
{

    public function getSelectFrom()
    {
        $formname = $this->getFormObj()->parentFormName;
        if (!$formname) {
            $formname = "extend.widget.ExtendSettingListEditForm";
        }
        return Openbiz::getObject($formname)
                ->parentFormElementMeta['ATTRIBUTES']['ACCESSSELECTFROM'];
    }

    protected function translateList(&$list, $tag)
    {
        $package = $this->getSelectFrom();
        I18n::AddLangData(substr($package, 0, intval(strpos($package, '.'))), "extend");
        parent::translateList($list, $tag);
    }

}
