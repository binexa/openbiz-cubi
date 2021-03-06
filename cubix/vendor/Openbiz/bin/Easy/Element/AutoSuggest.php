<?PHP
/**
 * Openbiz Framework
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
 * @version   $Id: AutoSuggest.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

namespace Openbiz\Easy\Element;

use Openbiz\Openbiz;
//include_once ("OptionElement.php");

/**
 * AutoSuggest class  is element for AutoSuggest
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class AutoSuggest extends OptionElement
{

    public function readMetaData (&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->cssClass = isset($xmlArr["ATTRIBUTES"]["CSSCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSCLASS"] : "input_text";
        $this->cssErrorClass = isset($xmlArr["ATTRIBUTES"]["CSSERRORCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSERRORCLASS"] : $this->cssClass . "_error";
        $this->cssFocusClass = isset($xmlArr["ATTRIBUTES"]["CSSFOCUSCLASS"]) ? $xmlArr["ATTRIBUTES"]["CSSFOCUSCLASS"] : $this->cssClass . "_focus";
    }

    /**
     * Render element, according to the mode
     *
     * @return string HTML text
     */
    public function render ()
    {
        if (defined('OPENBIZ_JSLIB_BASE') && OPENBIZ_JSLIB_BASE == 'JQUERY') {
			$inputName = $this->objectName;
			$style = $this->getStyle();
			$sHTML = "<input type=\"text\" id=\"$inputName\" name=\"$inputName\" value=\"$this->value\"/ $style>\n";
			$sHTML .= "<script>Openbiz.AutoSuggest.init('$this->formName','AutoSuggest','$inputName');</script>";
			return $sHTML;
		}
		
		Openbiz::$app->getClientProxy()->appendScripts("scriptaculous", "scriptaculous.js");
        $selFrom = $this->selectFrom;
        $pos0 = strpos($selFrom, "[");
        $pos1 = strpos($selFrom, "]");
        $first_half = substr($selFrom, 0, $pos1);
        $inputName = $this->objectName;
        $inputChoice = $this->objectName . '_choices';
        $style = $this->getStyle();
        if ($formobj->errors[$this->objectName]) {
            $func .= "onchange=\"this.className='$this->cssClass'\"";
        } else {
            $func .= "onfocus=\"this.className='$this->cssFocusClass'\" onblur=\"this.className='$this->cssClass'\"";
        }
        if (strpbrk($first_half, ':')) {
            $hInputName = $this->objectName . '_hidden';
            $inputChoice = $this->objectName . '_hidden_choices';
            $sHTML = "<input type=\"text\" id=\"$hInputName\" name=\"$hInputName\" value=\"$this->value\" $style $func/>\n";
            $sHTML .= "<div id=\"$inputChoice\" class=\"autocomplete\" style=\"display:none\"></div>\n";
            $sHTML .= "<script>Openbiz.AutoSuggest.init('$this->formName','AutoSuggest','$hInputName','$inputChoice');</script>";
            $sHTML .= "<INPUT NAME=\"" . $inputName . "\" ID=\"" . $inputName . "\" VALUE=\"" . $this->value . "\" type=\"hidden\" >";
        } else {
            $sHTML = "<input type=\"text\" id=\"$inputName\" name=\"$inputName\" value=\"$this->value\" $style $func/>\n";
            $sHTML .= "<div id=\"$inputChoice\" class=\"autocomplete\" style=\"display:none\"></div>\n";
            $sHTML .= "<script>Openbiz.AutoSuggest.init('$this->formName','AutoSuggest','$inputName','$inputChoice');</script>";
        }
        return $sHTML;
    }

    public function matchRemoteMethod ($method)
    {
        return ($method == "autosuggest");
    }
}
?>