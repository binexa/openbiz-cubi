<?php
include_once (Openbiz::$app->getModulePath()."/system/lib/ModuleLoadHandler.php");

class ContactLoadHandler extends DefaultModuleLoadHandler 
{
	protected $roleName = 'Contact Member';
	protected $moduleName = 'contact';   
}
