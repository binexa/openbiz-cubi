<?php 
//include_once("Element.php");

class IFrameBox extends Element
{
	
    public $link;
    public $m_Label;
    public $m_Scrolling;
    
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->link = isset($xmlArr["ATTRIBUTES"]["LINK"]) ? $xmlArr["ATTRIBUTES"]["LINK"] : null;
        $this->m_Label = isset($xmlArr["ATTRIBUTES"]["LABEL"]) ? $xmlArr["ATTRIBUTES"]["LABEL"] : null;    
        $this->m_Scrolling = isset($xmlArr["ATTRIBUTES"]["SCROLLING"]) ? $xmlArr["ATTRIBUTES"]["SCROLLING"] : 'auto';
    }    
    protected function getLink()
    {
        if ($this->link == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->link, $formobj);
    }
	protected function getWidth()
    {
        if ($this->width == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->width, $formobj);
    }
	protected function getHeight()
    {
        if ($this->height == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->height, $formobj);
    }
    
    public function renderLabel()
    {
        return $this->m_Label;
    }    	
	public function render(){	
		$link = $this->getLink();
		$text = $this->getText();	
		$height = $this->getHeight();
		$width = $this->getWidth();
		$sHTML = "<iframe  src=\"$link\" width=\"$width\" height=\"$height\" frameborder=\"0\" scrolling=\"".$this->m_Scrolling."\" >
					<p>$text</p></iframe>";        
        return $sHTML;
		
	}
}
?>