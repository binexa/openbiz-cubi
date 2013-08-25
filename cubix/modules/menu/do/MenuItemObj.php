<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.menu.do
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: MenuItemObj.php 3364 2012-05-31 06:06:21Z rockyswen@gmail.com $
 */

class MenuItemObj
{
 	public $recordId;
 	public $recordParentId;   
    public $objectName;   
    public $objectDescription;
    public $m_URL;
    public $m_URL_Match;
	public $m_Target;
	public $m_CssClass;
	public $m_IconImage;
	public $m_IconCSSClass;
	public $childNodes = null;
	 
    function __construct($xmlArr, $pid="0")
    {
    	$this->recordParentId		 = $pid;
    	$this->readMetadata($xmlArr);
    }
    
    function readMetadata($xmlArr){
        $this->recordId		 	 = $xmlArr["ATTRIBUTES"]["ID"];        
    	$this->objectName         = $xmlArr["ATTRIBUTES"]["NAME"];
        $this->objectDescription = $xmlArr["ATTRIBUTES"]["DESCRIPTION"];
        $this->m_URL		 = $xmlArr["ATTRIBUTES"]["URL"];
        $this->m_URL		 = Expression::evaluateExpression($this->m_URL, $this);
        $this->m_URL_Match	 = $xmlArr["ATTRIBUTES"]["URLMATCH"];
        $this->m_Target		 = $xmlArr["ATTRIBUTES"]["TARGET"];        
        $this->m_CssClass		 = $xmlArr["ATTRIBUTES"]["CSSCLASS"];
        $this->m_IconImage		 = $xmlArr["ATTRIBUTES"]["ICONIMAGE"];
        $this->m_IconCSSClass		 = $xmlArr["ATTRIBUTES"]["ICONCSSCLASS"];
        if(is_array($xmlArr["MENUITEM"])){
        	$this->childNodes = array();
        	if(isset($xmlArr["MENUITEM"]["ATTRIBUTES"])){
        		$this->childNodes[$xmlArr["MENUITEM"]["ATTRIBUTES"]["ID"]] = new MenuItemObj($xmlArr["MENUITEM"],$this->recordId);
        	}else{        	
	        	foreach($xmlArr["MENUITEM"] as $menuItem){
	        		$this->childNodes[$menuItem["ATTRIBUTES"]["ID"]] = new MenuItemObj($menuItem,$this->recordId);
	        	}
        	}
        }
    	
    }
    
    
    
}
?>