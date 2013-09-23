<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy.element
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: Element.php 4049 2011-05-01 12:56:06Z jixian2003 $
 */

/**
 * Element class is the base class of all HTML Element
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class Element extends MetaObject implements iUIControl
{
    public $style;
    public $cssClass;
    public $cssErrorClass;
    public $width;
    public $height;
    public $bizDataObj;
    public $m_Hidden = "N";       // support expression
    public $m_HTMLAttr;
    public $m_Label;
    public $m_EventHandlers;
    public $m_Translatable;
    public $m_FuzzySearch;
    public $m_OnEventLog;
    public $allowURLParam = 'N';
    public $m_XMLMeta;

    public $m_SortFlag;
    public $value = "";
    public $m_FormName;
    public $m_Extra;
    public $m_ElementSet;
    public $m_ElementSetCode;
    public $m_TabSet;
    public $m_TabSetCode;
    public $m_FieldName;
    public $required = null;
    public $validator = null;
    public $clientValidator = null;
	public $m_KeepCookie = null;
	public $cookieLifetime = 3600;
	public $backgroundColor;
	
	public $dataRole = "";
	
    /**
     * Initialize Element with xml array
     *
     * @param array $xmlArr
     * @return void
     */
    function __construct(&$xmlArr, $formObj)
    {
    	$this->m_XMLMeta = $xmlArr;
        $this->m_FormName = $formObj->objectName;
        $this->m_Package = $formObj->m_Package;

        $this->readMetaData($xmlArr);
                
        $this->translate();	// translate for multi-language support
    }

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        $this->objectName = isset($xmlArr["ATTRIBUTES"]["NAME"]) ? $xmlArr["ATTRIBUTES"]["NAME"] : null;
        $this->bizDataObj = isset($xmlArr["ATTRIBUTES"]["BIZDATAOBJ"]) ? $xmlArr["ATTRIBUTES"]["BIZDATAOBJ"] : null;
		$this->backgroundColor = isset($xmlArr["ATTRIBUTES"]["BACKGROUNDCOLOR"]) ? $xmlArr["ATTRIBUTES"]["BACKGROUNDCOLOR"] : null;        
        $this->className = isset($xmlArr["ATTRIBUTES"]["CLASS"]) ? $xmlArr["ATTRIBUTES"]["CLASS"] : null;
        $this->objectDescription = isset($xmlArr["ATTRIBUTES"]["DESCRIPTION"]) ? $xmlArr["ATTRIBUTES"]["DESCRIPTION"] : null;
        $this->access = isset($xmlArr["ATTRIBUTES"]["ACCESS"]) ? $xmlArr["ATTRIBUTES"]["ACCESS"] : null;
        $this->defaultValue = isset($xmlArr["ATTRIBUTES"]["DEFAULTVALUE"]) ? $xmlArr["ATTRIBUTES"]["DEFAULTVALUE"] : null;
        $this->cssClass = isset($xmlArr["ATTRIBUTES"]["CSSCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSCLASS"] : null;
        $this->cssErrorClass = isset($xmlArr["ATTRIBUTES"]["CSSERRORCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSERRORCLASS"] : "input_error";
        $this->style = isset($xmlArr["ATTRIBUTES"]["STYLE"]) ? $xmlArr["ATTRIBUTES"]["STYLE"] : null;
        $this->width = isset($xmlArr["ATTRIBUTES"]["WIDTH"]) ? $xmlArr["ATTRIBUTES"]["WIDTH"] : null;
        $this->height = isset($xmlArr["ATTRIBUTES"]["HEIGHT"]) ? $xmlArr["ATTRIBUTES"]["HEIGHT"] : null;
        $this->m_Hidden = isset($xmlArr["ATTRIBUTES"]["HIDDEN"]) ? $xmlArr["ATTRIBUTES"]["HIDDEN"] : null;
        $this->m_HTMLAttr = isset($xmlArr["ATTRIBUTES"]["HTMLATTR"]) ? $xmlArr["ATTRIBUTES"]["HTMLATTR"] : null;
        $this->m_ElementSet = isset($xmlArr["ATTRIBUTES"]["ELEMENTSET"]) ? $xmlArr["ATTRIBUTES"]["ELEMENTSET"] : null;
        $this->m_ElementSetCode = isset($xmlArr["ATTRIBUTES"]["ELEMENTSET"]) ? $xmlArr["ATTRIBUTES"]["ELEMENTSET"] : null;          
        $this->m_TabSet = isset($xmlArr["ATTRIBUTES"]["TABSET"]) ? $xmlArr["ATTRIBUTES"]["TABSET"] : null;
        $this->m_TabSetCode = isset($xmlArr["ATTRIBUTES"]["TABSET"]) ? $xmlArr["ATTRIBUTES"]["TABSET"] : null;
        $this->text = isset($xmlArr["ATTRIBUTES"]["TEXT"]) ? $xmlArr["ATTRIBUTES"]["TEXT"] : null;
        $this->m_Translatable = isset($xmlArr["ATTRIBUTES"]["TRANSLATABLE"]) ? $xmlArr["ATTRIBUTES"]["TRANSLATABLE"] : null;
        $this->m_FuzzySearch = isset($xmlArr["ATTRIBUTES"]["FUZZYSEARCH"]) ? $xmlArr["ATTRIBUTES"]["FUZZYSEARCH"] : null;
        $this->m_OnEventLog = isset($xmlArr["ATTRIBUTES"]["ONEVENTLOG"]) ? $xmlArr["ATTRIBUTES"]["ONEVENTLOG"] : null;
        $this->required = isset($xmlArr["ATTRIBUTES"]["REQUIRED"]) ? $xmlArr["ATTRIBUTES"]["REQUIRED"] : null;
        $this->validator = isset($xmlArr["ATTRIBUTES"]["VALIDATOR"]) ? $xmlArr["ATTRIBUTES"]["VALIDATOR"] : null;
        $this->clientValidator = isset($xmlArr["ATTRIBUTES"]["CLIENTVALIDATOR"]) ? $xmlArr["ATTRIBUTES"]["CLIENTVALIDATOR"] : null;
        $this->allowURLParam = isset($xmlArr["ATTRIBUTES"]["ALLOWURLPARAM"]) ? $xmlArr["ATTRIBUTES"]["ALLOWURLPARAM"] : 'Y';
        $this->m_KeepCookie = isset($xmlArr["ATTRIBUTES"]["KEEPCOOKIE"]) ? $xmlArr["ATTRIBUTES"]["KEEPCOOKIE"] : 'N';
        $this->cookieLifetime = isset($xmlArr["ATTRIBUTES"]["COOKIELIFETIME"]) ? (int)$xmlArr["ATTRIBUTES"]["COOKIELIFETIME"] : '3600';
		$this->dataRole = isset($xmlArr["ATTRIBUTES"]["DATAROLE"]) ? $xmlArr["ATTRIBUTES"]["DATAROLE"] : null;
		$this->m_Extra = isset($xmlArr["ATTRIBUTES"]["EXTRA"]) ? $xmlArr["ATTRIBUTES"]["EXTRA"] : null;

        // read EventHandler element
        if (isset($xmlArr["EVENTHANDLER"]))  // 2.1 eventhanlders
            $this->m_EventHandlers = new MetaIterator($xmlArr["EVENTHANDLER"],"EventHandler");

        if ($this->m_EventHandlers != null)
        {
            foreach ($this->m_EventHandlers as $eventHandler)
                $eventHandler->setFormName($this->m_FormName, $this->objectName);
        }

        // additional data in HTMLAttr
		$this->m_HTMLAttr .= ($this->dataRole) ? " data-role='".$this->dataRole."'" : "";
        $this->m_HTMLAttr .= " title='".$this->objectDescription."'"." clientValidator='".$this->clientValidator."'";
    }

    /**
     * Get form ({@link EasyForm}) object
     *
     * @return EasyForm
     */
    protected function getFormObj()
    {
        return BizSystem::objectFactory()->getObject($this->m_FormName);
    }

    //
    /**
     * Adjust form ({@link EasyForm}) name
     * change the form name after inherit from parent form
     *
     * @param string $formName
     * @return void
     */
    public function adjustFormName($formName)
    {
        if ($this->m_FormName == $formName)
            return;
        $this->m_FormName = $formName;
        if ($this->m_EventHandlers != null)
        {
            foreach ($this->m_EventHandlers as $eventHandler)
                $eventHandler->adjustFormName($this->m_FormName);
        }
    }

    public function reset()
    {
    	$this->value = null;
    	if ($this->m_EventHandlers != null)
        {
            foreach ($this->m_EventHandlers as $eventHandler)
                $eventHandler->m_FormedFunction = null;
        }
    }

    /**
     * Set value of element
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;        
        if($this->m_KeepCookie=='Y'){
        	if($value!=""){
        		$formName = $this->getFormObj()->objectName;       
        		setcookie($formName."-".$this->objectName,$value,time()+(int)$this->cookieLifetime,"/");
        	}
        }
    }

    /**
     * Get value of element
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get property of element
     *
     * @param string $propertyName
     * @return mixed
     */
    public function getProperty($propertyName)
    {
        if ($propertyName == "Value") return $this->getValue();
        $ret = parent::getProperty($propertyName);
        if ($ret) return $ret;
        return $this->$propertyName;
    }

    /**
     * Check if the element can be displayed
     *
     * @return boolean
     */
    public function canDisplayed()
    {
        if (!$this->allowAccess())
            return false;
        if ($this->getHidden() == "Y")
            return false;
        return true;
    }

    /**
     * Get default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        if ($this->defaultValue == "" && $this->m_KeepCookie!='Y')
            return "";
        $formObj = $this->getFormObj();
        if($this->m_KeepCookie=='Y'){
        	$cookieName = $formObj->objectName."-".$this->objectName;      
        	$cookieName = str_replace(".","_",$cookieName);
        	$defValue = $_COOKIE[$cookieName];         	       
        }                
        if(!$defValue){
        	$defValue = Expression::evaluateExpression($this->defaultValue, $formObj);
        }
        //add automatic append like new record (2)
        if($this->defaultValueRename!='N'){
	        if(!is_numeric($defValue)){
		        $dataobj = $formObj->getDataObj();
		        if($this->m_FieldName && $dataobj){
		        	if(substr($this->m_FieldName,0,1)!='_'){        	
			        	$recs = $dataobj->directfetch("[".$this->m_FieldName."] = '$defValue' OR "."[".$this->m_FieldName."] LIKE '$defValue (%)'" );	        	
			        	if($recs->count()>0){
			        		$defValue.= " ( ".$recs->count()." )";
			        	}
		        	}
		        }
	        }
        }
        return $defValue;
    }

    /**
     * Render the element by html
     *
     * @return string HTML text
     */
    public function render()
    {
     	return "";
    }

    public function renderLabel()
    {        
        $sHTML = $this->translateString($this->m_Label);       
        return $sHTML;
    }    
    
    /**
     * Get hidden status
     *
     * @return mixed
     */
    protected function getHidden()
    {
		if (!$this->m_Hidden || $this->m_Hidden=='N') return "N";
        $formObj = $this->getFormObj();
        return Expression::evaluateExpression($this->m_Hidden, $formObj);
    }

    /**
     * Get style of element
     *
     * @return string
     */
    protected function getStyle()
    {        
		$formobj = $this->getFormObj();
        $htmlClass = Expression::evaluateExpression($this->cssClass, $formobj);
        $htmlClass = "CLASS='$htmlClass'";
        if(!$htmlClass){
        	$htmlClass = null;
        }
        $style ='';
        if ($this->width && $this->width>=0)
            $style .= "width:".$this->width."px;";
        if ($this->height && $this->height>=0)
            $style .= "height:".$this->height."px;";
        if ($this->style)
            $style .= $this->style;
        if (!isset($style) && !$htmlClass)
            return null;
        if (isset($style))
        {
            
            $style = Expression::evaluateExpression($style, $formobj);
            $style = "STYLE='$style'";
        }
        if($formobj->m_Errors[$this->objectName])
        {
      	    $htmlClass = "CLASS='".$this->cssErrorClass."'";
        }
        if ($htmlClass)
            $style = $htmlClass." ".$style;
        return $style;
    }

    protected function getBackgroundColor()
    {
        if ($this->backgroundColor == null)
            return null;   
        $formObj = $this->getFormObj();
        return Expression::evaluateExpression($this->backgroundColor, $formObj);
    }        
    
    /**
     * Get text of element
     *
     * @return string
     */
    protected function getText()
    {
        if ($this->text == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->text, $formobj);
    }
    
    public function getDescription()
    {
        if ($this->objectDescription == null)
            return null;
        $formobj = $this->getFormObj();
        $text =  Expression::evaluateExpression($this->objectDescription, $formobj);
        $text = str_replace("[b]","<strong>",$text);
        $text = str_replace("[/b]","</strong>",$text);
        return $text;
    }    

    /**
     * Get shortcut key function map
     *
     * @return array
     */
    public function getSCKeyFuncMap()
    {
        if (!$this->canDisplayed()) return null;

        $map = array();
        /**
         * @todo need to remove, not used (mr_a_ton)
         */
        //$formObj = $this->getFormObj(); // not used

        if ($this->m_EventHandlers == null)
            return null;
        foreach ($this->m_EventHandlers as $eventHandler)
        {
            if ($eventHandler->m_ShortcutKey)
            {
                $map[$eventHandler->m_ShortcutKey] = $eventHandler->getFormedFunction();
            }
        }
        return $map;
    }

    /**
     * Get context menu
     *
     * @return array
     */
    public function getContextMenu()
    {
        if (!$this->canDisplayed()) return null;
        $menus = array();
        $formObj = $this->getFormObj();
        if ($this->m_EventHandlers == null)
            return null;
        $i = 0;
        foreach ($this->m_EventHandlers as $eventHandler)
        {
            if ($eventHandler->contextMenu)
            {
                $menus[$i]['text'] = $eventHandler->contextMenu;
                $menus[$i]['func'] = $eventHandler->getFormedFunction();
                $menus[$i]['key']  = $eventHandler->m_ShortcutKey;
            }
            $i++;
        }
        return $menus;
    }

    /**
     * Get function of element in JavaScript format
     *
     * @return string
     */
    protected function getFunction()
    {
        $events = $this->getEvents();
		foreach ($events as $event=>$function){
			if(is_array($function)){
				foreach($function as $f){
					$function_str.=$f.";";
				}
				$func .= " $event=\"$function_str\"";
			}else{
				$func .= " $event=\"$function\"";
			}
		}
        return $func;
    }
    
    public function getEvents(){
    	$name = $this->objectName;
        // loop through the event handlers
        $func = "";

        $events = array();
        
        if ($this->m_EventHandlers == null)
            return $events;
        $formobj = $this->getFormObj();
       
        foreach ($this->m_EventHandlers as $eventHandler)
        {
            $ehName = $eventHandler->objectName;
            $event = $eventHandler->m_Event;
            $type = $eventHandler->m_FunctionType;
            if (!$event) continue;
            if($events[$event]!=""){
            	$events[$event]=array_merge(array($events[$event]),array($eventHandler->getFormedFunction()));
            }else{
            	$events[$event]=$eventHandler->getFormedFunction();
            }
        }
        return $events;
    }
    
    public function getFunctionByEventHandlerName($eventHandlerName)
    {
    	if ($this->m_EventHandlers == null)
            return null;
    	$eventHandler = $this->m_EventHandlers->get($eventHandlerName);
    	if ($eventHandler)
    		$func = Expression::evaluateExpression($eventHandler->m_Function, $formobj);
    	return $func;
    }

    /**
     * Get redirect page
     *
     * @param string $eventHandlerName event handler name
     * @return string
     */
    public function getRedirectPage($eventHandlerName)
    {
        $formObj = $this->getFormObj();
        $eventHandler = $this->m_EventHandlers->get($eventHandlerName);
        if (!$eventHandler) return null;
        //echo $evthandler->m_RedirectPage."<br>";
        return Expression::evaluateExpression($eventHandler->m_RedirectPage, $formObj);
    }

    /**
     * Get parameter
     *
     * @param string $eventHandlerName
     * @return mixed
     */
    public function getParameter($eventHandlerName){
    	$formObj = $this->getFormObj();
        $eventHandler = $this->m_EventHandlers->get($eventHandlerName);
        if (!$eventHandler) return null;
        //echo $evthandler->m_RedirectPage."<br>";
        return Expression::evaluateExpression($eventHandler->m_Parameter, $formObj);
    }
    
    /**
     * Get function type
     *
     * @param string $eventHandlerName event handler name
     * @return string function type in string format
     */
    public function getFunctionType($eventHandlerName)
    {
        $eventHandler = $this->m_EventHandlers->get($eventHandlerName);
        if (!$eventHandler) return null;
        return $eventHandler->m_FunctionType;
    }

    /**
     * Check if element must required (must have value)
     *
     * @return boolean
     */
    public function checkRequired()
    {
        if (!$this->required || $this->required == "")
            return false;
        else if ($this->required == "Y")
            $required = true;
        else if($this->required == "N")
            $required = false;
        else{
            $required = Expression::evaluateExpression($this->required, $this->getFormObj());
            if(strtoupper($required)=='Y')
            {
            	$required=true;
            }
            elseif(strtoupper($required)=='N')
            {
            	
            }
            else
            {            	
            	$required=false;
            }
        }
        return $required;
    }

    /**
     * Validate element
     * 
     * @return boolean
     */
    public function validate()
    {
        $ret = true;
        if ($this->validator)
            $ret = Expression::evaluateExpression($this->validator, $this->getFormObj());
        return $ret;
    }

    /**
     * Get client validator
     *
     * @return string
     */
    public function getClientValidator()
    {
        if ($this->clientValidator)
            return $this->clientValidator;

        //return Expression::evaluateExpression($this->clientValidator, $this->getFormObj());
        return null;
    }
    
    public function matchRemoteMethod($method)
    {
        return false;
    }
    
    protected function translate()
    {
    	$module = $this->getModuleName($this->m_FormName);
    	if (!empty($this->text))
    		$this->text = I18n::t($this->text, $this->getTransKey('Text'), $module, $this->getTransPrefix());
    	if (!empty($this->m_Label))
    		$this->m_Label = I18n::t($this->m_Label, $this->getTransKey('Label'), $module, $this->getTransPrefix());
    	if (!empty($this->objectDescription))
    		$this->objectDescription = I18n::t($this->objectDescription, $this->getTransKey('Description'), $module, $this->getTransPrefix());
        if (!empty($this->defaultValue) && !preg_match("/\{/si",$this->defaultValue))
    		$this->defaultValue = I18n::t($this->defaultValue, $this->getTransKey('DefaultValue'), $module, $this->getTransPrefix());
		if (!empty($this->m_ElementSet))
    		$this->m_ElementSet = I18n::t($this->m_ElementSet, $this->getTransKey('ElementSet'), $module, $this->getTransPrefix());
    	if (!empty($this->blankOption))
    		$this->blankOption = I18n::t($this->blankOption, $this->getTransKey('BlankOption'), $module, $this->getTransPrefix());
    	if (!empty($this->m_TabSet))
    		$this->m_TabSet = I18n::t($this->m_TabSet, $this->getTransKey('TabSet'), $module, $this->getTransPrefix());  
    	if (!empty($this->m_Hint))
    		$this->m_Hint = I18n::t($this->m_Hint, $this->getTransKey('Hint'), $module, $this->getTransPrefix());  		
    }

	protected function getTransPrefix()
    {    	
    	$nameArr = explode(".",$this->m_FormName);
    	for($i=1;$i<count($nameArr)-1;$i++)
    	{
    		$prefix .= strtoupper($nameArr[$i])."_";
    	}
    	return $prefix;
    }    
    
    protected function getTransKey($name)
    {
    	$shortFormName = substr($this->m_FormName,intval(strrpos($this->m_FormName,'.')+1));
    	return strtoupper($shortFormName.'_'.$this->objectName.'_'.$name);
    }
    
    protected function translateString($value)
    {
        $module = $this->getModuleName($this->m_FormName);
        if(defined($value)) $value = constant($value);
        return I18n::t($value, 'STRING_'.$value, $module);
    }
    
    public function getDataObj()
    {
    	if(!$this->bizDataObj){
    		return $this->getFormObj()->getDataObj();
    	}else{
    		return BizSystem::getDataObject($this->bizDataObj);
    	}
    }
}

/**
 * EventHandler class is manage event handler of element
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class EventHandler
{
    public $objectName;
    public $m_Event;
    public $m_Function;     // support expression
    public $m_FunctionType;
    public $m_PostAction;   // support expression
    public $m_ShortcutKey;
    public $contextMenu;
    public $m_RedirectPage;
    public $m_Parameter;
    public $m_EventLogMsg;
    public $m_FormedFunction;
    private $_formName;
    private $_elemName;

    // add URL here so that direct url string can be given
    public $m_URL;

    /**
     * Initialize EventHandler with xml array
     *
     * @param array $xmlArr
     * @return void
     */
    function __construct(&$xmlArr)
    {
        $this->objectName = isset($xmlArr["ATTRIBUTES"]["NAME"]) ? $xmlArr["ATTRIBUTES"]["NAME"] : null;
        $this->m_Event = isset($xmlArr["ATTRIBUTES"]["EVENT"]) ? $xmlArr["ATTRIBUTES"]["EVENT"] : null;
        $this->m_Function = isset($xmlArr["ATTRIBUTES"]["FUNCTION"]) ? $xmlArr["ATTRIBUTES"]["FUNCTION"] : null;
        $this->m_OrigFunction = $this->m_Function;
        $this->m_FunctionType = isset($xmlArr["ATTRIBUTES"]["FUNCTIONTYPE"]) ? $xmlArr["ATTRIBUTES"]["FUNCTIONTYPE"] : null;
        $this->m_PostAction = isset($xmlArr["ATTRIBUTES"]["POSTACTION"]) ? $xmlArr["ATTRIBUTES"]["POSTACTION"] : null;
        $this->m_ShortcutKey = isset($xmlArr["ATTRIBUTES"]["SHORTCUTKEY"]) ? $xmlArr["ATTRIBUTES"]["SHORTCUTKEY"] : null;
        $this->contextMenu = isset($xmlArr["ATTRIBUTES"]["CONTEXTMENU"]) ? $xmlArr["ATTRIBUTES"]["CONTEXTMENU"] : null;
        $this->m_RedirectPage = isset($xmlArr["ATTRIBUTES"]["REDIRECTPAGE"]) ? $xmlArr["ATTRIBUTES"]["REDIRECTPAGE"] : null;        
		$this->m_Parameter = isset($xmlArr["ATTRIBUTES"]["PARAMETER"]) ? $xmlArr["ATTRIBUTES"]["PARAMETER"] : null;        
        $this->m_EventLogMsg = isset($xmlArr["ATTRIBUTES"]["EVENTLOGMSG"]) ? $xmlArr["ATTRIBUTES"]["EVENTLOGMSG"] : null;
        $this->m_URL = isset($xmlArr["ATTRIBUTES"]["URL"]) ? $xmlArr["ATTRIBUTES"]["URL"] : null;
    }

    /**
     * Set form name that contain element and EventHandler
     * 
     * @param string $formName
     * @param string $elemName
     * @return void
     */
    public function setFormName($formName, $elemName)
    {
        $this->_formName = $formName;
        $this->_elemName = $elemName;
        if (strpos($this->m_Function, "js:")===0)
            return;
        // if no class name, add default class name. i.e. NewRecord => ObjName.NewRecord
        if ($this->m_Function)
        {
            $pos_dot = strpos($this->m_Function, ".");
            $pos_lpt = strpos($this->m_Function, "(");
            if (!$pos_dot || $pos_lpt < $pos_dot)
                $this->m_Function = $this->_formName.".".$this->m_Function;
        }
        $this->translate();	// translate for multi-language support
    }

    /**
     * Adjust form name
     *
     * @param string $formName
     * @return void
     */
    public function adjustFormName($formName)
    {
        $this->_formName = $formName;
        // if no class name, add default class name. i.e. NewRecord => ObjName.NewRecord
        if ($this->m_Function)
        {
        	if(strtolower(substr($this->m_Function,0,3))!='js:'){
				$pos0 = strpos($this->m_Function, "(");
				$len = strlen($this->m_Function);
				if ($pos0 > 0)
					$pos = strrpos($this->m_Function, ".", $pos0-$len);
				else 
					$pos = strrpos($this->m_Function, ".");
				if ($pos > 0)
					$this->m_Function = $this->_formName.".".substr($this->m_Function, $pos+1);
			}
        }
    }

    /**
     * Get formed function
     *
     * @return string
     */
    public function getFormedFunction()
    {
        //return $this->getInvokeAction();
        $name = $this->_elemName;
        $ehName = $this->objectName;
        $formobj = BizSystem::objectFactory()->getObject($this->_formName);
        if ($this->m_FormedFunction)
        {
            return $this->m_FormedFunction;
        }        
        if (!$this->m_FormedFunction || $isDataPanelElement==true)
        {
            // add direct URL support
            if ($this->m_URL) 
            {
                $_func = "loadPage('" . $this->m_URL . "');";
                $_func = Expression::evaluateExpression($_func, $formobj);
            }
            else if (strpos($this->m_Function, "js:") === 0) 
            {
                $_func = substr($this->m_Function, 3).";";
                $_func = Expression::evaluateExpression($_func, $formobj);
            }
            else 
            {
                //$temp = ($this->m_FunctionType==null) ? "" : ",'".$this->m_FunctionType."'";
                //$_func = "SetOnElement('$name:$ehName'); $selectRecord CallFunction('" . $this->m_Function . "'$temp);";
                //$_func = "Openbiz.CallFunction('" . $this->m_Function . "'$temp);";
                $_func = Expression::evaluateExpression($this->m_Function, $formobj);
                $options = "{'type':'$this->m_FunctionType','target':'','evthdl':'$name:$ehName'}";
                $_func = "Openbiz.CallFunction('$_func',$options);";
            }
            $this->m_FormedFunction = $_func;
        }
        return $this->m_FormedFunction;
    }
    
    public function getInvokeAction()
    {
        if ($this->m_FormedFunction)
            return $this->m_FormedFunction;
    	$name = $this->_elemName;
        $ehName = $this->objectName;
        $formobj = BizSystem::objectFactory()->getObject($this->_formName);
     
        if (!$this->m_FormedFunction)
        {
            // add direct URL support
            if ($this->m_URL)
                $_func = "loadPage('" . $this->m_URL . "');";
            else if (strpos($this->m_Function, "js:") === 0)
                $_func = substr($this->m_Function, 3).";";
            else
            {
                $temp = ($this->m_FunctionType==null) ? "" : ",'".$this->m_FunctionType."'";                
                //$_func = "SetOnElement('$name:$ehName'); Openbiz.CallFunction('" . $this->m_Function . "'$temp);";
                list($funcName, $funcParams) = $this->parseFunction($this->m_Function);
                $funcParams = Expression::evaluateExpression($funcParams, $formobj);
                $action = "$name:$ehName";
                // TODO: encrypt paramString to add more security
                $_func = "Openbiz.invoke('$this->_formName','$action','$funcParams'$temp);";
            }
            //$_func = Expression::evaluateExpression($_func, $formobj);
            $this->m_FormedFunction = $_func;
        }
        return $this->m_FormedFunction;
    }
    
    // parse function string and get functionName and functionParams
    public function parseFunction($funcString)
    {
        $pos = strpos($funcString, "(");
        $pos1 = strpos($funcString, ")");
        if ($pos>0 && $pos1>$pos)
        {
            $funcName = substr($funcString,0,$pos);
            $funcParams = substr($funcString,$pos+1,$pos1-$pos-1);
            return array($funcName, $funcParams);
        }
        return null;
    }
    
    protected function translate()
    {
    	$module = substr($this->_formName,0,intval(strpos($this->_formName,'.')));
    	if (!empty($this->contextMenu))
    		$this->contextMenu = I18n::t($this->contextMenu, $this->getTransKey('ContextMenu'), $module);
    }
    
    protected function getTransKey($name)
    {
    	$shortFormName = substr($this->m_FormName,intval(strrpos($this->m_FormName,'.'))+1);
    	return strtoupper($shortFormName.'_'.$this->objectName.'_'.$name);
    }
    
}
?>