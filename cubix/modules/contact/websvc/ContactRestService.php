<?php

include_once Openbiz::$app->getModulePath().'/websvc/lib/RestService.php';

class ContactRestService extends RestService
{
	protected $resourceDOMap = array('contacts'=>'contact.do.ContactDO');
}
