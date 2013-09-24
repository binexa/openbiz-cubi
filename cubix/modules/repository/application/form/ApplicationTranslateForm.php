<?php 
include_once OPENBIZ_APP_MODULE_PATH.'/repository/category/form/CategoryTranslateForm.php';

class ApplicationTranslateForm extends CategoryTranslateForm
{
	protected $translateDO = "repository.application.do.ApplicationTranslateDO";
	protected $recordFKField = "repo_app_id";	
}
?>