<?php 

use Openbiz\Easy\EasyView;

class LoaderNotInstalledView extends EasyView
{
	public function render()
	{
		if(!extension_loaded('ionCube Loader'))
		{
			$result = parent::render();
			return $result;
		}else{
			header("Location: ".OPENBIZ_APP_INDEX_URL);
			exit;
		}
	}
	
}
