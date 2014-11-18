<?php

/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: sysclass_inc.php 4179 2011-05-26 07:40:53Z rockys $
 */

/**
 * MetaIterator class
 * MetaIterator is the base class of all derived metadata-driven classes who support iteration
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class MetaIterator implements Iterator
{

    /**
     * Parent object
     * @var object
     */
    protected $prtObj = null;

    /**
     * Store value
     * @var array
     */
    protected $varValue = array();

    /**
     * Contructor of class
     *
     * @param array $xmlArr
     * @param string $childClassName
     * @param object $parentObj
     * @return void
     */
    public function __construct(&$xmlArr, $childClassName, $parentObj = null)
    {
        //if (is_array($array)) $this->var = $array;
        $this->prtObj = $parentObj;
        if (!$xmlArr) {
            return;
        }
        if (isset($xmlArr["ATTRIBUTES"])) {
            $className = isset($xmlArr["ATTRIBUTES"]['CLASS']) ? $xmlArr["ATTRIBUTES"]['CLASS'] : $childClassName;
            if ((bool) strpos($className, ".")) {
                $a_package_name = explode(".", $className);
                $className = array_pop($a_package_name);
                //require_once(BizSystem::getLibFileWithPath($className, implode(".", $a_package_name)));
                $clsLoaded = BizClassLoader::loadMetadataClass($className, implode(".", $a_package_name));
            }
            //if (!$clsLoaded) trigger_error("Cannot find the load class $className", E_USER_ERROR);
            $obj = new $className($xmlArr, $parentObj);
            $this->varValue[$obj->objectName] = $obj;
        } else {
            foreach ($xmlArr as $child) {
                $className = isset($child["ATTRIBUTES"]['CLASS']) ? $child["ATTRIBUTES"]['CLASS'] : $childClassName;

                /**
                 * If a '.' is found within className we need to require such class
                 * and then get the className after the last dot
                 * ex. shared.dataobjs.FieldName, in this case FieldName is the class, shared/dataobjs the path
                 *
                 * The best solution to this is enable object factory to specify its resulting object constructor parameters
                 */
                if ($className) { //bug fixed by jixian for resolve load an empty classname
                    if ((bool) strpos($className, ".")) {
                        $a_package_name = explode(".", $className);
                        $className = array_pop($a_package_name);
                        //require_once(BizSystem::getLibFileWithPath($className, implode(".", $a_package_name)));
                        $clsLoaded = BizClassLoader::loadMetadataClass($className, implode(".", $a_package_name));
                    } elseif ($parentObj->package) {
                        /* if(is_file(BizSystem::getLibFileWithPath($className, $parentObj->package))){
                          require_once(BizSystem::getLibFileWithPath($className, $parentObj->package));
                          }; */
                        $clsLoaded = BizClassLoader::loadMetadataClass($className, $parentObj->package);
                    }
                    //if (!$clsLoaded) trigger_error("Cannot find the load class $className", E_USER_ERROR);
                    $obj = new $className($child, $parentObj);
                    $this->varValue[$obj->objectName] = $obj;
                }
            }
        }
    }

    /**
     * Merge to another MetaIterator object
     *
     * @param MetaIterator $anotherMIObj another MetaIterator object
     * @return void
     */
    public function merge(&$anotherMIObj)
    {
        $old_varValue = $this->varValue;
        $this->varValue = array();
        foreach ($anotherMIObj as $key => $value) {
            if (!$old_varValue[$key]) {
                $this->varValue[$key] = $value;
            } else {
                $this->varValue[$key] = $old_varValue[$key];
            }
        }
        foreach ($old_varValue as $key => $value) {
            if (!isset($this->varValue[$key])) {
                $this->varValue[$key] = $value;
            }
        }
    }

    /**
     * Get value
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->varValue[$key]) ? $this->varValue[$key] : null;
    }

    /**
     * Set value
     *
     * @param mixed $key
     * @param mixed $val
     */
    public function set($key, $val)
    {
        $this->varValue[$key] = $val;
    }

    /**
     * Clear value
     *
     * @param mixed $key
     * @param mixed $val
     */
    public function clear($key)
    {
        unset($this->varValue[$key]);
    }

    public function count()
    {
        return count($this->varValue);
    }

    /**
     * Rewind
     *
     * @return void
     */
    public function rewind()
    {
        reset($this->varValue);
    }

    /**
     * Current item
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->varValue);
    }

    /**
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->varValue);
    }

    /**
     * 
     * @return mixed
     */
    public function next()
    {
        return next($this->varValue);
    }

    /**
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->current() !== false;
    }

}

/**
 * Parameter class
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class Parameter
{

    public $objectName, $value, $required, $inOut;

    public function __construct(&$xmlArr)
    {
        $this->objectName = isset($xmlArr["ATTRIBUTES"]["NAME"]) ? $xmlArr["ATTRIBUTES"]["NAME"] : null;
        $this->value = isset($xmlArr["ATTRIBUTES"]["VALUE"]) ? $xmlArr["ATTRIBUTES"]["VALUE"] : null;
        $this->required = isset($xmlArr["ATTRIBUTES"]["REQUIRED"]) ? $xmlArr["ATTRIBUTES"]["REQUIRED"] : null;
        $this->inOut = isset($xmlArr["ATTRIBUTES"]["INOUT"]) ? $xmlArr["ATTRIBUTES"]["INOUT"] : null;
    }

    /**
     * Get property
     *
     * @param string $propertyName property name
     * @return mixed
     */
    public function getProperty($propertyName)
    {
        if ($propertyName == "Value")
            return $this->value;
        return null;
    }

}

/**
 * iSessionObject interface - stateful metadata-driven classed need to implement saveSessionVars and loadSessionVars
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
interface iSessionObject
{

    public function saveSessionVars($sessCtxt);

    public function loadSessionVars($sessCtxt);
}

/**
 * iUIControl interface, all UI classes need to implement Render method
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
interface iUIControl
{

    public function render();
}

/**
 * BDOException
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class BDOException extends Exception
{
    
}

/**
 * BFMException
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class BFMException extends Exception
{
    
}

/**
 * BSVCException
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class BSVCException extends Exception
{
    
}

/**
 * ValidationException
 *
 * @package   openbiz.bin
 * @author    Rocky Swen
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class ValidationException extends Exception
{

    public $errors;   // key, errormessage pairs

    public function __construct($errors)
    {
        $this->errors = $errors;
        $message = "";
        foreach ($errors as $key => $err) {
            $message .= "$key = $err, ";
        }
        $this->message = $message;
    }

}
include_once "EventManager.php";
