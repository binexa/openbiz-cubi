<?php

use Openbiz\Object\MetaIterator;
use Openbiz\Easy\EasyView;

class MyProfileView extends EasyView {

    protected $forceCompeleteProfile = false;

    public function loadStatefullVars($sessionContext) {
        $sessionContext->loadObjVar($this->objectName, "ForceCompeleteProfile", $this->forceCompeleteProfile);
    }

    public function saveStatefullVars($sessionContext) {
        $sessionContext->saveObjVar($this->objectName, "ForceCompeleteProfile", $this->forceCompeleteProfile);
    }

    public function isForceCompeleteProfile() {
        return $this->forceCompeleteProfile;
    }

    public function render() {
        if (isset($_GET['force'])) {
            $this->forceCompeleteProfile = true;
        } else {
            $this->forceCompeleteProfile = false;
        }

        if ($this->isForceCompeleteProfile()) {
            //var_dump($this->formRefs);
            $formRefArr = array(
                "ATTRIBUTES" => array(
                    "NAME" => 'myaccount.form.ProfileEditForm'
                ),
                "VALUE" => null
            );
            $this->formRefs = new MetaIterator($formRefArr, "FormReference", $this);
        }

        return parent::render();
    }

}
