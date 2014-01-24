<?php 
include_once Openbiz::$app->getModulePath().'/repository/category/form/CategoryTranslateForm.php';

class ApplicationTranslateForm extends CategoryTranslateForm
{
	protected $translateDO = "repository.application.do.ApplicationTranslateDO";
	protected $recordFKField = "repo_app_id";	
}
