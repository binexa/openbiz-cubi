<?php

/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.menu.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: MenuWidget.php 5327 2013-03-25 05:09:15Z agus.suhartono@gmail.com $
 */
include_once OPENBIZ_APP_MODULE_PATH . DIRECTORY_SEPARATOR . 'menu' . DIRECTORY_SEPARATOR . 'widget' . DIRECTORY_SEPARATOR . 'MenuRenderer.php';

class MenuWidget extends MetaObject implements iUIControl
{

    public $m_Title;
    public $objectDescription;
    public $m_StartMenuItem;
    public $m_StartMenuID;
    public $searchRule;
    public $m_GlobalSearchRule;
    public $m_MenuDeep;
    public $m_TemplateEngine;
    public $m_TemplateFile;
    public $m_DataObjName;
    public $cacheLifeTime;
    public $m_CssClass;
    protected $m_DataObj;

    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
        $this->translate();
    }

    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->objectName = $this->prefixPackage($this->objectName);
        $this->m_Title = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TITLE"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TITLE"] : null;
        $this->objectDescription = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["DESCRIPTION"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["DESCRIPTION"] : null;
        $this->m_CssClass = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["CSSCLASS"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["CSSCLASS"] : null;
        $this->m_TemplateEngine = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TEMPLATEENGINE"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TEMPLATEENGINE"] : null;
        $this->m_TemplateFile = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TEMPLATEFILE"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["TEMPLATEFILE"] : null;
        $this->m_StartMenuItem = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["STARTMENUITEM"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["STARTMENUITEM"] : null;
        $this->m_StartMenuID = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["STARTMENUID"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["STARTMENUID"] : null;
        $this->searchRule = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["SEARCHRULE"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["SEARCHRULE"] : null;
        $this->m_GlobalSearchRule = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["GLOBALSEARCHRULE"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["GLOBALSEARCHRULE"] : null;
        $this->m_MenuDeep = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["MENUDEEP"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["MENUDEEP"] : null;
        $this->m_DataObjName = $this->prefixPackage($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["BIZDATAOBJ"]);
        $this->cacheLifeTime = isset($xmlArr["MENUWIDGET"]["ATTRIBUTES"]["CACHELIFETIME"]) ? $xmlArr["MENUWIDGET"]["ATTRIBUTES"]["CACHELIFETIME"] : "0";
        $this->translate();
    }

    public function render()
    {
        if (!$this->allowAccess())
            return "";
        if ($this->cacheLifeTime > 0) {
            $cache_id = md5($this->objectName);
            //try to process cache service.
            $cacheSvc = BizSystem::getService(CACHE_SERVICE, 1);
            $cacheSvc->init($this->objectName, $this->cacheLifeTime);

            if ($cacheSvc->test($cache_id)) {
                BizSystem::log(LOG_DEBUG, "MENU", "Cache Hit. menu widget name = " . $this->objectName);
                $output = $cacheSvc->load($cache_id);
            } else {
                BizSystem::log(LOG_DEBUG, "MENU", "Set cache. menu widget = " . $this->objectName);
                $output = $this->renderHTML();
                $cacheSvc->save($output, $cache_id);
            }
            return $output;
        }
        $renderedHTML = $this->renderHTML();
        return $renderedHTML;
    }

    protected function renderHTML()
    {
        //include_once(dirname(__FILE__)."/MenuRenderer.php");   
        $sHTML = MenuRenderer::render($this);
        return $sHTML;
    }

    public function fetchMenuTree()
    {
        $dataObj = $this->getDataObj();
        if ($this->searchRule != "") {
            $tree = $dataObj->fetchTreeBySearchRule($this->searchRule, $this->m_MenuDeep, $this->m_GlobalSearchRule);
        } else if ($this->m_StartMenuID != "") {
            $tree = $dataObj->fetchTree($this->m_StartMenuID, $this->m_MenuDeep);
        } else {
            $tree = $dataObj->fetchTreeByName($this->m_StartMenuItem, $this->m_MenuDeep);
        }
        return $tree;
    }

    public function outputAttrs()
    {
        $attrs = array();
        $attrs['name'] = $this->objectName;
        $attrs['title'] = $this->m_Title;
        $attrs['css'] = $this->m_CssClass;
        $attrs['description'] = $this->objectDescription;
        $attrs['menu'] = $this->fetchMenuTree();
        $attrs['breadcrumb'] = $this->getDataObj()->getBreadCrumb();
        //if ($this->objectName=="menu.widget.MainTabMenu") { print_r($attrs['menu']);   print_r($attrs['breadcrumb']);  }
        return $attrs;
    }

    protected function prefixPackage($name)
    {
        if ($name && !strpos($name, ".") && ($this->m_Package)) // no package prefix as package.object, add it
            $name = $this->m_Package . "." . $name;

        return $name;
    }

    final public function getDataObj()
    {
        if (!$this->m_DataObj) {
            if ($this->m_DataObjName)
                $this->m_DataObj = BizSystem::getObject($this->m_DataObjName, 1);
            if ($this->m_DataObj)
                $this->m_DataObj->m_BizFormName = $this->objectName;
            else {
                //BizSystem::clientProxy()->showErrorMessage("Cannot get DataObj of ".$this->m_DataObjName.", please check your metadata file.");
                return null;
            }
        }
        return $this->m_DataObj;
    }

    public function setRequestParams()
    {
        
    }

    protected function translate()
    {
        $module = $this->getModuleName($this->objectName);
        $this->m_Title = I18n::t($this->m_Title, $this->getTransKey('Title'), $module);
        $this->objectDescription = I18n::t($this->objectDescription, $this->getTransKey('Description'), $module);
    }

    protected function getTransKey($name)
    {
        $shortFormName = substr($this->objectName, intval(strrpos($this->objectName, '.')) + 1);
        return strtoupper($shortFormName . '_' . $name);
    }

    public function getModuleName($name)
    {
        return substr($name, 0, intval(strpos($name, '.')));
    }

}

?>