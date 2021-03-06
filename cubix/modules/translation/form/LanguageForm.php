<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.translation.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LanguageForm.php 3374 2012-05-31 06:22:06Z rockyswen@gmail.com $
 */

use Openbiz\Openbiz;
use Openbiz\I18n\I18n;
use Openbiz\Helpers\TemplateHelper;
use Openbiz\Easy\EasyForm;

include_once Openbiz::$app->getModulePath()."/translation/lib/LangPackCreator.php";


class LanguageForm extends EasyForm
{
	public $lang_Region;
	public $lang_Icon;

	public function getActiveRecord($recId=null)
    {
        if ($this->activeRecord != null)
        {
            if($this->activeRecord['Id'] != null)
            {
                return $this->activeRecord;
            }
        }

        if ($recId==null || $recId=='')
            $recId = Openbiz::$app->getClientProxy()->getFormInputs('_selectedId');
        if ($recId==null || $recId=='')
            return null;
        $this->recordId = $recId;
		$rec=array();
        $this->ReadLangPack($recId,$rec);
        $this->dataPanel->setRecordArr($rec);
        $this->activeRecord = $rec;
        return $rec;
    }
	
	public function InsertRecord()
	{
        $recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
                           
            
        try
        {
	        $lang = $recArr['lang'];
	        $this->validateErrors = array();
	        if(is_dir(OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang)){	        			       	
	        		$errorMessage = $this->getMessage("FORM_LANG_EXIST",array("fld_lang"));
	                $this->validateErrors["fld_lang"] = $errorMessage;
	        }
	        if (count($this->validateErrors) > 0)
	        {
	            throw new Openbiz\Validation\Exception($this->validateErrors);
	        }
        }
        catch (Openbiz\Validation\Exception $e)
        {
            $this->processFormObjError($e->errors);
            return;
        }

        $this->CreateLangPack($lang , $recArr);
        

        $this->processPostAction();		
	}
	
	public function UpdateRecord()
	{
		$recArr = $this->readInputRecord();        
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
		
        preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->fixSearchRule,$match);
		$lang = $match[2];		
        $this->UpdateLangPack($lang , $recArr);
        

        $this->processPostAction();		
	}

   public function deleteRecord($id=null)
    {
        if ($this->resource != "" && !$this->allowAccess($this->resource.".delete"))
            return Openbiz::$app->getClientProxy()->redirectView(OPENBIZ_ACCESS_DENIED_VIEW);

        if ($id==null || $id=='')
            $id = Openbiz::$app->getClientProxy()->getFormInputs('_selectedId');

        $selIds = Openbiz::$app->getClientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {
            $this->DeleteLangPack($id);            
        }
        if (strtoupper($this->formType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }
    	
	public function fetchData(){
		if (strtoupper($this->formType) == "NEW")
            return $this->getNewLang();
                        
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->fixSearchRule,$match);
		$lang = $match[2];
		$dir = OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$locale = explode('_', $lang);
		$result['Id']	=	$lang;
		$result['name']	=	$lang;	
		$result['lang']	=	$lang;			
		$result['path']	=	$dir;				
		$result['code']	=	$lang;
		$result['default']	=	$this->isDefaultLang($lang);		
		$result['users']	=	"0";
		
		$this->ReadLangPack($lang,$result);
		if($locale[1]){
			$result['language']	=	$this->Code2Language($locale[0]);
			$result['region']	=	$this->Code2Region($locale[1]);
			$result['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
			
		}
		else
		{
			$result['language']	=	$this->Code2Language($locale[0]);
			$result['region']	=	$this->Code2Region($locale[0]);
			$result['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
			
		}		
		$this->recordId = $lang;
		return $result;
	}
	
	public function fetchDataSet(){
		$result = array();
		$i = 0;
		foreach (glob(OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR."*",GLOB_ONLYDIR) as $dir){
			if(basename($dir)!='tmp' && basename($dir)!='dictionary'){
				$locale = explode('_', basename($dir));

				$result[$i]['Id']	=	basename($dir);
				$result[$i]['name']	=	basename($dir);	
				$result[$i]['path']	=	$dir;				
				$result[$i]['code']	=	basename($dir);
				$result[$i]['default']	=	$this->isDefaultLang(basename($dir));
				$result[$i]['users']	=	"0";
				$this->ReadLangPack(basename($dir),$result[$i]);
				
				if($locale[1]){
					$result[$i]['lang']	=	$this->Code2Language($locale[0]);
					$result[$i]['region']	=	$this->Code2Region($locale[1]);
					$result[$i]['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
					
				}
				else
				{
					$result[$i]['lang']	=	$this->Code2Language($locale[0]);
					$result[$i]['region']	=	$this->Code2Region($locale[0]);
					$result[$i]['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
				}
				$i++;	
			}
		}
		if(!$this->recordId){
			$this->recordId=$result[0]["Id"];
		}
		return $result;
	}

	public function Code2Name($code){
		$result = $this->Code2Region($code, 'en_US' );
		return $result;
	}
	
	public function isDefaultLang($lang){
		if($lang == OPENBIZ_DEFAULT_LANGUAGE){
			return true;
		}
		else
		{
			return false;
		}
	}

    protected function getNewLang()
    {
        $recArr = $this->readInputRecord();        
        // load default values if new record value is empty
        $defaultRecArr = array();
        foreach ($this->dataPanel as $element)
        {
            if ($element->fieldName)
            {
                $defaultRecArr[$element->fieldName] = $element->getDefaultValue();
            }
        }

        foreach ($recArr as $field => $val)
        {
            if ( $defaultRecArr[$field] != "" && $val=="")
            {
                $recArr[$field] = $defaultRecArr[$field];
            }
        }
        if(count($recArr)==0){
        	$recArr=$defaultRecArr;
        }
        $selected_lang = Openbiz::$app->getClientProxy()->getFormInputs("fld_region");
        if(!$selected_lang)
        {
			$selected_lang = "en_ad";
            $recArr['lang'] = "en_AG";	
        }else{
        	$country = $selected_lang; 	
	    	$country = strtoupper($country);  
	    	if(!$country){    		
	    		$locale = explode('_', $current_locale);
	    		$country = strtoupper($locale[0]);
	    	}  	

			$locale = new \Zend_Locale($current_locale);
			$code2name = $locale->getTranslationList('territorytolanguage',$locale);
			$list = array();
			$i=0;
			foreach($code2name as $key => $value){	
				
				if(preg_match('/'.$country.'/',$value) || strtoupper($key)==$country){				
					$lang_list = explode(" ",$value);				
					foreach($lang_list as $lang){
						$list[$i]['txt'] = strtolower($key)."_".strtoupper($lang);
						$list[$i]['val'] = strtolower($key)."_".strtoupper($lang);
						$i++;
						break;break;
					}
				}
			}
			$recArr['lang'] = $list[0]['val'];	
        }
        $locale = explode('_', $selected_lang);
    	if($locale[1]){
			$recArr['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[1]).'.png';
    	}
		else
		{
			$recArr['icon']	=	OPENBIZ_APP_URL."/images/nations/22x14/".strtolower($locale[0]).'.png';
		}
		
		
        return $recArr;
    }	


	
	public function Code2Language($code,$locale=null){
		$code=strtolower($code);
		//require_once('Zend/Locale.php');
		$locale = new \Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('language',$locale);
		$result = $code2name[$code];
		$locale = null;
		$code2name = null;
		return $result;
	}

	public function Code2Region($code,$locale=null){
		$code=strtoupper($code);
		//require_once('Zend/Locale.php');
		$locale = new \Zend_Locale(I18n::getCurrentLangCode());
		$code2name = $locale->getTranslationList('territory',$locale);
		$result = $code2name[$code];
		$locale = null;
		$code2name = null;
		return $result;
	}
	
	public function CreateLangPack($lang,$recArr){
		$this->recordID=$lang;
		$locale = explode('_', $lang);
	    $lang_code = strtolower($locale[0]);
		
		//mkdir
		$lang_dir = OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		@mkdir($lang_dir);
		
		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create lang.xml metainfo
		$smarty = TemplateHelper::getSmartyTemplate();
		$smarty->assign("language", 		$this->Code2Language($lang_code));
		$smarty->assign("lang_code", 		$lang);
		$smarty->assign("version", 			$recArr['version']);
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(TemplateHelper::getTplFileWithPath("lang.xml.tpl", $this->package));
		file_put_contents($lang_dir.DIRECTORY_SEPARATOR.$lang.".xml" ,$data);
		
		
		//generate lang string files.
		$creator = new LangPackCreator($lang);
		$creator->createNew();
		return true;		
	}
	
public function UpdateLangPack($lang,$recArr){
		$this->recordID=$lang;
		$locale = explode('_', $lang);
	    $lang_code = strtolower($locale[0]);

		//clean up array
		foreach($recArr as $key=>$value){
			$recArr[$key] = addslashes($recArr[$key]);
			$recArr[$key] = str_replace("\n",'\n',$recArr[$key]);
		}
		
		//create lang.xml metainfo
		$smarty = TemplateHelper::getSmartyTemplate();
		$smarty->assign("language", 		$this->Code2Language($lang_code));
		$smarty->assign("lang_code", 		$lang);
		$smarty->assign("version", 			$recArr['version']);
		$smarty->assign("create_date", 		$recArr['creationDate']);
		$smarty->assign("author", 			$recArr['author']);
		$smarty->assign("author_email", 	$recArr['authorEmail']);
		$smarty->assign("author_url", 		$recArr['authorUrl']);
		$smarty->assign("description",	 	$recArr['description']);
		$data = $smarty->fetch(TemplateHelper::getTplFileWithPath("lang.xml.tpl", $this->package));
		$lang_dir = OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$lang_file = $lang_dir.DIRECTORY_SEPARATOR.$lang.".xml";
		@unlink($lang_file);
		file_put_contents($lang_file ,$data);
		
		
		//generate lang string files.
		
		return true;		
	}
	
	public function ReadLangPack($lang,&$recArr=array()){		
		$lang_dir = OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$lang_metafile = $lang_dir.DIRECTORY_SEPARATOR.$lang.".xml";
		if(is_file($lang_metafile)){
			$metadata = file_get_contents($lang_metafile);
			$xmldata = new SimpleXMLElement($metadata);		
			foreach ($xmldata as $key=>$value){
				if(substr($key,0,1)!="@")
				{
					$str=(string)$value;
					$str=str_replace('\n',"\n",$str);
					$str=stripcslashes($str);
					$recArr[$key]=$str;
				}
			}
		}
		return $recArr;		
	}

	public function DeleteLangPack($lang){		
		$dir = OPENBIZ_APP_PATH.DIRECTORY_SEPARATOR."languages".DIRECTORY_SEPARATOR.$lang;
		$iterator = new RecursiveDirectoryIterator($dir);
		   foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file)
		   {
			      if ($file->isDir()) {
			         @rmdir($file->getPathname());
			      } else {
			         @unlink($file->getPathname());
			      }
		   		
		   }
		   
		   	@rmdir($dir);	
	    	
		return true;		
	}
		
}

