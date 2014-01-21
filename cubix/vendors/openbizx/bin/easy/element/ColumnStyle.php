<?php 
//include_once("RawData.php");

class ColumnStyle extends RawData{

    public function setSortFlag($flag=null)
    {
        $this->sortFlag = $flag;
    }
	
    public function renderLabel()
    {
        return null;
    }	
}

?>