<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: HTMLTabs.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

/**
 * HTMLTabs class is the base class of HTML tabs
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @since 1.2
 * @access public
 */
class HTMLTabs extends MetaObject implements iUIControl
{
    public $templateFile;
    public $m_TabViews = null;
    protected $currentTab = null;
    protected $activeCssClassName = null;
    protected $m_InactiveCssClassName = null;

    /**
     * Initialize HTMLTabs with xml array
     *
     * @param array $xmlArr
     * @return void
     */
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    }

    /**
     * Read Metadata from xml array
     *
     * @param array $xmlArr
     */
    protected function readMetadata(&$xmlArr)
    {
        $this->objectName = $xmlArr["TABS"]["ATTRIBUTES"]["NAME"];
        $this->m_Package = $xmlArr["TABS"]["ATTRIBUTES"]["PACKAGE"];
        $this->className = $xmlArr["TABS"]["ATTRIBUTES"]["CLASS"];
        $this->templateFile = $xmlArr["TABS"]["ATTRIBUTES"]["TEMPLATEFILE"];
        $this->m_TabViews = new MetaIterator($xmlArr["TABS"]["TABVIEWS"]["VIEW"],"TabView");
        $this->activeCssClassName = "'{$xmlArr["TABS"]["ATTRIBUTES"]["ACTIVECSSCLASSNAME"]}'";
        $this->m_InactiveCssClassName = "'{$xmlArr["TABS"]["ATTRIBUTES"]["INACTIVECSSCLASSNAME"]}'";
    }

    /**
     * Render JS Code to create multidimensional array of forms for a given HTMLTab
     *
     * @param array $forms
     * @return array $js_array
     **/
    private function _renderJSCodeForForms($forms)
    {
        $js_array="new Array(";
        if($forms)
        {
            foreach($forms as $form)
            {
                if(!is_null($form))
                {
                    $js_array.="new Array('{$form['NAME']}','{$form['VISIBLE']}'),";
                }
                else
                {
                    // No array entry will be created
                }
            }
            $js_array = rtrim($js_array,',').")";
        }
        else
        {
            $js_array = 'null';
        }
        return $js_array;
    }

    /**
     * Render a URL for hide or show forms or in another case, go to URL specified in xml
     *
     * @param TabView $tabView
     * @return string javascript string to either show a EasyForm or load a different URL
     **/
    private function _renderURL($tabView)
    {
        if($tabView->hasForms())
        {
            $url = "javascript:ChangeTab(this, {$tabView->objectName}_config)";
        }
        else if($tabView->m_URL)
        {
            $url = $tabView->m_URL;
        }
        else
        {
            $url = "javascript:Openbiz.Net.loadView('{$tabView->m_View}')";
        }

        return $url;
    }

    /**
     * Set current tab with view name
     *
     * @param string $viewName name of a view
     * @return void
     */
    public function setCurrentTab($viewName)
    {
        $this->currentTab = $viewName;
    }

    /**
     * Ask if the $this tab object is the current tab
     *
     * @param TabView $tabView
     * @param EasyView $curViewObj current View Object
     * @param string $curViewName name of the current view
     * @return boolean TRUE if on the current tab, otherwise FALSE
     */
    public function isCurrentTab($tabView, $curViewObj, $curViewName)
    { //--jmmz
        $currentTab = false; //this variable save 'true' if is the current tab and 'false' in otherwise --jmmz
        if ($this->currentTab)
        {
            $currentTab = ($this->currentTab == $tabView->objectName || $this->currentTab == $tabView->m_Tab)
                    ? TRUE
                    : FALSE;
        }
        elseif ($tabView->m_ViewSet)
        {
            if ($curViewObj)
            // check if current view's viewset == tview->m_ViewSet
                $currentTab = ($curViewObj->getViewSet() == $tabView->m_ViewSet) ? true : false;
        }
        else
        {
            $currentTab = ($curViewName == $tabView->m_View || $curViewObj->m_Tab == $tabView->objectName) ? true : false;
        }

        return $currentTab;
    }

    /**
     * Save the current tab in the session object
     *
     * @param TabView $tview
     * @param EasyView $curViewObj current View Object
     * @param string $curViewName name of the current view
     * @return void
     */
    public function setCurrentTabInSession($tview, $curViewObj, $curViewName)
    {
        $sessionContext = BizSystem::sessionContext();

        if (!$sessionContext->varExists('CURRENT_TAB_'.$this->objectName))
        {
            if ($this->isCurrentTab($tview,$curViewObj, $curViewName))
            {
                $sessionContext->setVar('CURRENT_TAB_'.$this->objectName,$tview->objectName);
            }
            else
            {
                //Don't set var if isn't the current var
            }
        }
        else
        {
            $this->setCurrentTab($sessionContext->getVar('CURRENT_TAB_'.$this->objectName));
        }
    }

    /**
     * Render the html tabs
     *
     * @global BizSystem $g_BizSystem
     * @return string html content of the tabs
     */
    public function render()
    {
        global $g_BizSystem;

        $curView = $g_BizSystem->getCurrentViewName();
        $curViewobj = ($curView) ? BizSystem::getObject($curView) : null;

        $profile = $g_BizSystem->getUserProfile();
        $svcobj = BizSystem::getService(ACCESS_SERVICE);
        $role = isset($profile["ROLE"]) ? $profile["ROLE"] : null;

        // list all views and highlight the current view
        // pass $tabs(caption, url, target, icon, current) to template
        $smarty = BizSystem::getSmartyTemplate();
        $tabs = array();
        $i = 0;
        $hasForms = false;
        foreach ($this->m_TabViews as $tview)
        {
            // tab is renderd if  no definition  is found in accessservice.xml (default)
            if ($svcobj->allowViewAccess($tview->m_View, $role))
            {

                $tabs[$i]['name']=$tview->objectName; //Name of each tab--jmmz
                $tabs[$i]['forms']=$this->_renderJSCodeForForms($tview->m_Forms);//Configuration of the forms to hide or show--jmmz
                $tabs[$i]['caption'] = $tview->caption;

                $tabs[$i]['url'] = $this->_renderURL($tview); //Call the method to render the url--jmmz

                //If I have forms to hide or show I add the event because I don't need an URL, I need an event
                if( (bool) $tview->hasForms() )
                {
                    $tabs[$i]['event']=$tabs[$i]['url']; //Assign The url rendered to the event on click
                    $tabs[$i]['url']='javascript:void(0)'; //If I put url in '' then the href want send me to another direction
                    $this->setCurrentTabInSession($tview, $curViewobj, $curView); //I set the current tab wrote in session
                    $hasForms = TRUE;
                }

                $tabs[$i]['target'] = $tview->m_Target;
                $tabs[$i]['icon'] = $tview->m_Icon;
                $tabs[$i]['current'] = $this->isCurrentTab($tview,$curViewobj, $curView); //I get the current tab.
                $i++;
            }
        }
        $this->setClientScripts($tabs, $hasForms);
        $smarty->assign("tabs", $tabs);
        $smarty->assign("tabs_Name",$this->objectName);

        return $smarty->fetch(BizSystem::getTplFileWithPath($this->templateFile, $this->m_Package));
    }

    /**
     * Rerender the tabs
     *
     * @return string html content of the menu
     */
    public function rerender()
    {
        return $this->render();
    }

    /**
     * Include client javascripts or CSS in the html content
     *
     * @param array $tabs
     * @param boolean $hasForms
     * @return void
     */
    protected function setClientScripts($tabs, $hasForms)
    {
        global $g_BizSystem;

        BizSystem::clientProxy()->appendScripts("tabs", "tabs.js");
        BizSystem::clientProxy()->appendStyles("tabs", "tabs.css");

        if ($hasForms)
        {
            $tab_script = '<script type = "text/javascript">'.PHP_EOL;
            foreach ($tabs as $tab)
            {
                $tab_script .=   'var '.$tab['name'].'_config = '.$tab['forms'].';'.PHP_EOL;
            }
            $tab_script .=   'var '.$this->objectName.'_active = '.$this->activeCssClassName.';'.PHP_EOL;
            $tab_script .=   'var '.$this->objectName.'_inactive = '.$this->m_InactiveCssClassName.';'.PHP_EOL;
            $tab_script .= '</script>';
            BizSystem::clientProxy()->appendScripts("tab_forms_$this->objectName", $tab_script, FALSE);
        }
    }

}

/**
 * TabView class is internal class mapping to the metadata of View element in HTMLTabs
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @since 1.2
 * @access public
 */
class TabView
{
    public $objectName;
    public $m_View;
    public $m_ViewSet;
    public $caption;
    public $m_URL;
    public $m_Target;
    public $m_Icon;
    public $m_Forms; //Forms for hide or show in a BizView

    /**
     * Get forms or the form to hide or show.
     * When It has one form It hasn't the ATTRIBUTES property
     *
     * @param array $forms
     * @return array
     **/
    private function _getForms($forms)
    {
        $recArr=array();
        if (count($forms) == 0 )
            return $recArr;

        foreach($forms as $form)
        {
            if(!is_null($form["ATTRIBUTES"]))
                $recArr[]=$form["ATTRIBUTES"];
            else
                $recArr[]=$form;
        }
        return $recArr;
    }

    /**
     * Initialize TabView with xml array
     *
     * @param array $xmlArr
     * @return void
     */
    function __construct(&$xmlArr)
    {
        $this->objectName = $xmlArr["ATTRIBUTES"]["NAME"];
        $this->m_View = $xmlArr["ATTRIBUTES"]["VIEW"];
        if(array_key_exists("VIEWSET", $xmlArr["ATTRIBUTES"]))
            $this->m_ViewSet = $xmlArr["ATTRIBUTES"]["VIEWSET"];
        $this->caption = $this->translate($xmlArr["ATTRIBUTES"]["CAPTION"]);
        if(array_key_exists("URL", $xmlArr["ATTRIBUTES"]))
            $this->m_URL = $xmlArr["ATTRIBUTES"]["URL"];
        if(array_key_exists("TARGET", $xmlArr["ATTRIBUTES"]))
            $this->m_Target = $xmlArr["ATTRIBUTES"]["TARGET"];
        if(array_key_exists("ICON", $xmlArr["ATTRIBUTES"]))
            $this->m_Icon = $xmlArr["ATTRIBUTES"]["ICON"];


        $this->m_Forms = NULL;
        if(array_key_exists("FORM", $xmlArr))
            $this->m_Forms = $this->_getForms($xmlArr["FORM"]);     //Get form or forms to hide or show

        //$this->m_Forms = (!is_null($xmlArr["FORM"]))?$this->getForms($xmlArr["FORM"]):null;
    }

    /**
     * Return TRUE if the current tabView has forms related to it
     *
     * @return bool
     */
    function hasForms()
    {
        return (bool) $this->m_Forms;
    }

    protected function translate($caption)
    {
    	$module = $this->getModuleName($this->objectName);
   		return I18n::t($caption, $this->getTransKey(caption), $module);
    }
    
    protected function getTransKey($name)
    {
    	$shortFormName = substr($this->objectName,intval(strrpos($this->objectName,'.'))+1);
    	return strtoupper($shortFormName.'_'.$name);
    }
}
?>