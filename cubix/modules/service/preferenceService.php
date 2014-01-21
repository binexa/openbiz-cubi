<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: preferenceService.php 5071 2013-01-07 08:15:03Z hellojixian@gmail.com $
 */

use Openbiz\Openbiz;

/**
 * User preference service 
 */
class preferenceService
{
    protected $name = "ProfileService";    
    protected $preferenceObj ;    
    protected $preference;

    public function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    }

    protected function readMetadata(&$xmlArr)
    {
        $this->preferenceObj = $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["BIZDATAOBJ"];
    }

    public function initPreference($userId)
    {
        $this->preference = $this->InitDBPreference($userId);
        Openbiz::$app->getSessionContext()->setVar("_USER_PREFERENCE", $this->preference);        
        Openbiz::$app->getSessionContext()->setVar("LANG",$this->preference['language']);
        Openbiz::$app->getSessionContext()->setVar("THEME",$this->preference['theme']);
        Openbiz::$app->getSessionContext()->setVar("TIMEZONE",$this->preference['timezone']);
        date_default_timezone_set($this->preference['timezone']);
        return $this->preference;
    }

    /**
     * Get user preference
     * 
     * @param type $attribute
     * @return null 
     */
    public function getPreference($attribute=null)
    {    	
        if (!$this->preference)
        {
            $this->preference = Openbiz::$app->getSessionContext()->getVar("_USER_PREFERENCE");
        }
        if (!$this->preference)
        {
        		return null;
        }
        if ($attribute){
        	if(isset($this->preference[$attribute])){
        		return $this->preference[$attribute];
        	}else{
        		return null;
        	}
        }
            
        return $this->preference;
    }

    /**
     * Set user preference
     * 
     * @param <type> $preference 
     */
    public function setPreference($attribute,$value=null)
    {    	    	    
        $this->preference[$attribute] = $value;
        Openbiz::$app->getSessionContext()->setVar("_USER_PREFERENCE", $this->preference);  
        //update user preference to DB 
        $do = Openbiz::getObject($this->preferenceObj);
        if (!$do)
            return false;
        $user_id = Openbiz::$app->getUserProfile("Id");
        $prefRec = $do->fetchOne("[user_id]='$user_id' AND [name]='$attribute'");
        $prefRec['value'] = (string) $value;
        return $prefRec->save();
    }
    
 
    /**
     * Initialize user preference from database
     * 
     * @param type $user_id
     * @return boolean 
     */
    protected function initDbPreference($user_id)
    {
        $do = Openbiz::getObject($this->preferenceObj);
        if (!$do)
            return false;

        $rs = $do->directFetch("[user_id]='$user_id'");
      
        if ($rs)
        {
	        	foreach ($rs as $item)
	        	{        		
	        		$preference[$item["name"]] = $item["value"];        	
	        	}	
        }
        return $preference;
    }

}
