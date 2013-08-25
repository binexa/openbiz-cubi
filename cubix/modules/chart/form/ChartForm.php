<?php

class ChartForm extends EasyForm
{
	public $chartCategory;
	public $chartDataset;
	public $chartDataAttrset;
	public $chartColorset;
	public $chartDescset;
	public $chartIdset;
    public $attributes;
    public $subType;
    public $selectedRecord;
    public $categoryId;
    
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->subType    = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTTYPE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTTYPE"] : null;
        $this->attributes   = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTATTRS"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTATTRS"] : null;
        $this->selectedRecord = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["SELECTRECORD"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["SELECTRECORD"] : null;
    }
    

    public function getSessionVars($sessionContext)
    {    	
    	$sessionContext->getObjVar($this->objectName, "CategoryId", $this->categoryId);
        $sessionContext->getObjVar($this->objectName, "SubType", $this->subType);
        return parent::getSessionVars($sessionContext);
    }


    public function setSessionVars($sessionContext)
    {
    	$sessionContext->setObjVar($this->objectName, "CategoryId", $this->categoryId);
        $sessionContext->setObjVar($this->objectName, "SubType", $this->subType);
        return parent::setSessionVars($sessionContext);        
    }    
	
	public function outputAttrs()
    {        
    	$output['name'] = $this->objectName;
        $output['title'] = $this->m_Title;
        $output['description'] = str_replace('\n', "<br />", $this->objectDescription);
        $output['data'] = $this->draw();
        $output['height'] = $this->height;
        $output['width'] = $this->width;
        $parent = parent::outputAttrs();
        foreach($parent as $key=>$value)
        {
        	$output[$key]=$value;
        }        
        return $output;
    }
    
    public function validateRequest($methodName)
    {
    	$methodName = strtolower($methodName);
        if ($methodName == "draw" || $methodName == "invoke") 
            return true;
        return parent::validateRequest($methodName);
    }
    
    public function fetchDataSet()
    {
    }
   
    protected function fetchDatasetByColumn()
    {    	
		$this->chartCategory = array();
		$this->chartDataAttrset = array();
		$this->chartDataset = array();
		$this->chartDataDescset = array();
		$this->chartDataIdset = array();
		$this->chartColorset = array();
    	// query recordset first
		$dataObj = $this->getDataObj();

        QueryStringParam::setBindValues($this->searchRuleBindValues);

        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();
         		
		//echo "search rule is $this->searchRule"; exit;
		if ($this->m_FixSearchRule)
        {
            if ($this->searchRule)
                $searchRule = $this->searchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
        $searchRule = $this->searchRule;
        $dataObj->setSearchRule($searchRule);
        if($this->m_StartItem>1)
        {
            $dataObj->setLimit($this->m_Range, $this->m_StartItem);
        }
        else
        {
            $dataObj->setLimit($this->m_Range, ($this->m_CurrentPage-1)*$this->m_Range);
        }
        QueryStringParam::setBindValues($this->searchRuleBindValues);
        $resultRecords = $dataObj->fetch();
        $this->m_TotalRecords = $dataObj->count();
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		//$resultRecords = $dataObj->directFetch($searchRule);
		$counter = 0;
        while (true)
        {
            $arr = $resultRecords[$counter];
            if (!$arr) break;
            foreach ($this->m_DataPanel as $element)
            {            	
            	$element->value = $arr[$element->fieldName];
            	$value = $element->getValue();            	
            	if ($element->fieldName && isset($value))
            	{	            	            			            		
            		switch($element->className)
            		{
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $value;            				
            				break;
            			case "chart.lib.ChartDataId":
            				$this->chartIdset[] = $value;
            				break;
            			case "chart.lib.ChartDescription":
            				$this->chartDescset[] = $value;
            				break;
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $value;
            				break;
            			case "chart.lib.ChartCategory":
            				$this->chartCategory[] = $value;
            				break;
            			case "chart.lib.ChartData":
            				$this->chartDataset[$element->key][] 	 = $value;
            		    	$this->chartDataAttrset[$element->key] = $element->attrs;
            				break;
            		}
            	}
            }
            $counter++;
        }      
    }
    
    public function draw()
    {
    	ob_clean();
		$path = OPENBIZ_APP_MODULE_PATH.'/chart/lib';
    	set_include_path(get_include_path() . PATH_SEPARATOR . $path);    	
        if(strtolower(CUBI_FUSION_CHART_VERSION)=="pro"){
    		require_once(dirname(dirname(__FILE__)).'/lib/fusionpro/FusionCharts_Gen.php'); 		
    		require_once(dirname(dirname(__FILE__)).'/lib/fusionpro/FusionCharts.php');
    	}
    	else
    	{
        	require_once(dirname(dirname(__FILE__)).'/lib/fusion/FusionCharts_Gen.php');
        	require_once(dirname(dirname(__FILE__)).'/lib/fusion/FusionCharts.php');
    	} 
    	return $this->drawChart();
    }
    
    public function redrawChart(){
    	return $this->updateForm();
    }
    
    public function updateForm()
    {        
    	$data = $this->readInputRecord();
    	if($data['chart_type'])
    	{
    		$this->subType = $data['chart_type'];
    	}
    	return parent::updateForm();
    }
    
    public function runSearch()
    {
    	$data = $this->readInputRecord();
    	if($data['chart_type'])
    	{
    		$this->subType = $data['chart_type'];
    	}
    	return parent::runSearch();
    }
    
    //TODO: for different type of chart, use template? or render class?
    protected function drawChart()
    {
        $this->fetchDatasetByColumn(); 
        if ($this->checkChartType($this->subType) == false) {
            $errmsg = "Unsupported chart type $this->subType.";
            trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        
        if (count($this->chartDataset) > 1)
            return $this->drawMultiSeries();
        else if (count($this->chartDataset) == 1)
            return $this->drawSingleSeries();
        else {
            $errmsg = "Cannot draw chart due to empty data set.";
            //trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        return "";
    }
    
    protected function drawSingleSeries()
    {
    	//load color styles
    	$colorObj = BizSystem::getObject("chart.do.ChartColorDO");
    	$colorList = $colorObj->directFetch("");
    	
        $FC = new FusionCharts($this->subType, $this->width, $this->height); 
        $this->seChartParams($FC);
        if(is_array($this->chartDataset)){
	        foreach ($this->chartDataset as $key=>$ds) {
	            for ($i=0; $i<count($ds); $i++){
	            	$elemConfig = "name=".$this->chartCategory[$i].';'.$this->chartDataAttrset[$key].';';	            	
	            	if($this->chartColorset[$i])
	            	{
	            		$elemConfig.="color=".$this->chartColorset[$i].';';
	            		$elemConfig.="anchorBgColor=6bd0fe;";
	            		$elemConfig.="anchorBorderColor=0d78af;";       		
	            	}
	            	elseif($colorList[$i]["color_code"])
	            	{
	            		$elemConfig.="color=".$colorList[$i]["color_code"].';';
	            		$elemConfig.="anchorBgColor=".$colorList[$i]["color_code"].';';
	            		$elemConfig.="anchorBorderColor=".$colorList[$i]["color_code"].';';
	            	}
	            	//select record feature
	            	if($this->selectedRecord){
	            		$elemConfig .="link=JavaScript:Openbiz.CallFunction(\\\"".$this->objectName.".SelectRecord(".addslashes($this->chartIdset[$i]).")\\\");";
	            	}
	            	//desc text feature
	            	if($this->chartDescset[$i])
	            	{
	            		$elemConfig .="toolText=".addslashes($this->chartDescset[$i]).";";
	            	}
	            	//add anchor 
	            	$elemConfig .="anchorRadius=6;";
	                $FC->addChartData($ds[$i], $elemConfig);
	            }
	        }
        }
        
        return $FC->renderChart(false, false);
    }
    
    protected function drawMultiSeries()
    {
    	if (empty($this->chartCategory)) {
            $errmsg = "Please set category for multi series chart.";
            trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        //load color styles
    	$colorObj = BizSystem::getObject("chart.do.ChartColorDO");
    	$colorList = $colorObj->directFetch("");
    	    	
        $FC = new FusionCharts($this->subType, $this->width, $this->height); 
        $this->seChartParams($FC);
        # category names
        foreach ($this->chartCategory as $cat) {
            $FC->addCategory($cat);
        }
        $colorI=0;
        foreach ($this->chartDataset as $key=>$ds) {
            if(preg_match("/color=/si",$this->chartDataAttrset[$key])){
            	$color = "";
            }           
            elseif($this->chartColorset[$colorI])
            {
            	$color = "color=".$this->chartColorset[$colorI].";";
            }
            elseif($colorList[$colorI]["color_code"])
            {
        		$color = "color=".$colorList[$colorI]["color_code"].";";
            }
        	
            $elemConfig = $color.$this->chartDataAttrset[$key];                        
        	$FC->addDataset($key,$elemConfig);
            for ($i=0; $i<count($ds); $i++){
            	$setConfig ="link=JavaScript:Openbiz.CallFunction(\\\"".$this->objectName.".SelectRecord(".addslashes($colorI).",".addslashes($i).")\\\");";
                $FC->addChartData($ds[$i],$setConfig);
            }
            $colorI++;
        }
        return $FC->renderChart(false, false);
    }
    public function selectRecord($recId,$catId = null)
    {    	
    	if($catId!=null){
    		$this->categoryId = $catId;
    	}
    	return parent::selectRecord($recId);
    }
    protected function seChartParams($FC)
    {
    	if(strtolower(CUBI_FUSION_CHART_VERSION)=="pro"){
    		$FC->setSWFPath(OPENBIZ_RESOURCE_URL."/chart/js/FusionChartsPro/");    		
    	}
    	else
    	{
        	$FC->setSWFPath(OPENBIZ_RESOURCE_URL."/chart/js/FusionCharts/");
    	}
        
        # Set chart attributes
        //$FC->setChartParam('caption',$this->m_Title);
        $FC->setChartParam('formatNumberScale',1);
        $FC->setChartParam('decimalPrecision',0);
        
        if(strtolower(CUBI_FUSION_CHART_VERSION)=="pro"){
	        $FC->setChartParam('exportEnabled',1);
	        $FC->setChartParam('exportAtClient',0);
	        $FC->setChartParam('exportShowMenuItem',1);
	        $FC->setChartParam('exportAction',"save");
	        $FC->setChartParam('exportHandler',OPENBIZ_APP_URL."/js/FusionChartsPro/FCExporter.php");
	        $FC->setChartParam('exportFileName',$this->objectName);
        }
        //$strParam = "caption=".$this->m_Title.";canvasBorderColor=CECECE;baseFontSize=12;".$this->attributes;
        $strParam = "canvasBorderColor=CECECE;baseFontSize=10;".$this->attributes;
        $FC->setChartParams($strParam);
    }
    
    protected function checkChartType($type)
    {    
        switch ($this->subType) {
            case "Column2D" : 
            case "Column3D" : 
            case "Bar2D" : 
            case "Area2D" :
            case "Line" : 
            case "Pie2D" : 
            case "Pie3D" :
            case "MSColumn2D" :
            case "MSColumn2DLineDY" :
            case "MSColumn3D" :
            case "MSColumn3DLineDY" :
            case "MSBar2D" :
            case "MSArea2D" :
            case "MSLine" :
            case "StackedBar2D" : 
            case "StackedColumn2D" : 
            case "StackedColumn3D" : 
            case "StackedArea2D" :
                return true;
        }
        return false;
    }
    

}
?>