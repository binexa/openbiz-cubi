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
 * @version   $Id: ColumnImage.php 3742 2011-04-16 07:25:29Z jixian2003 $
 */

//include_once("ColumnText.php");

/**
 * ColumnImage class is element for ColumnImage,
 * show image on data list
 *
 * @package openbiz.bin.easy.element
 * @author Hu Zhaoxin, jixian2003
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class ColumnImage extends ColumnText
{
    /**
     * String for alternate attribute of image
     *    <img alt="$alt" />
     *
     * @var string
     */
    public $alt;

    /**
     * String for title attribute of image
     *    <img title="$alt" />
     * 
     * @var string
     */
    public $m_Title;
    public $m_ImgUrl; // image url prefix to the image path

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->alt = isset($xmlArr["ATTRIBUTES"]["ALT"]) ? $xmlArr["ATTRIBUTES"]["ALT"] : null;
        $this->m_Title = isset($xmlArr["ATTRIBUTES"]["TITLE"]) ? $xmlArr["ATTRIBUTES"]["TITLE"] : null;
        $this->m_ImgUrl = isset($xmlArr["ATTRIBUTES"]["IMGURL"]) ? $xmlArr["ATTRIBUTES"]["IMGURL"] : '';
    }

    /**
     * Get image alternate(ALT) attribut
     * 
     * @return string
     */
    protected function getAlt()
    {
        if ($this->alt == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->alt, $formobj);
    }

    /**
     * Get image title
     *
     * @return string
     */
    protected function getTitle()
    {
        if ($this->m_Title == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->m_Title, $formobj);
    }

    /**
     * Render element, according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
    	if(!$this->getText())
    	{
    		$val = ($this->m_ImgUrl) ? $this->m_ImgUrl.$this->value : $this->value;
    	}else{
    		if(preg_match("/\{OPENBIZ_RESOURCE_URL\}/si",$this->text)){
    			$val = $this->getText();
    		}else{
    			$val = Resource::getImageUrl()."/".$this->getText();
    		}
    	}
        if ($val == null || $val =="")
            return "";

        $style = $this->getStyle();
        $func = $this->getFunction();
        $alt = $this->getAlt();
        $title = $this->getTitle();

        if ($val)
        {
            if($height = $this->height)
            {
                $height = 'height="' . $height . '"';
            }

            if($width = $this->width)
            {
                $width = 'width="' . $width . '"';
            }

            $alt = 'alt="' . $alt . '"';
            $title = 'title="' . $title . '"';

            if ($this->link)
            {
                $link = $this->getLink();
                $target = $this->getTarget();
                $sHTML = "<a href=\"$link\" $target $func $style>" . "<img src=\"{$val}\" border=\"0\" $height $width $alt $title />" . "</a>";
            }
            else
            {
                $sHTML =  "<img $style $func border=\"0\" src=\"{$val}\" $height $width $alt $title />" ;
            }
        }
        return $sHTML;
    }

}

?>
