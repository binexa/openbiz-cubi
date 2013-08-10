<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BizRequest
 *
 * @author k6
 */
class BizRequest
{
    /**
     * Invocation type 'RPCInvoke', 'Invoke' or other.
     * Other is not valid invocation.
     * 
     * @var string 
     */
    public $invocationType;
    
    public $params;
    
    public function readArgument($param)
    {
        
    }

    /**
     * Check is invocation valid (RPCInvoke or Invoke) ?
     * 
     * @return type 
     */
    public function isValidInvocation($invocationType='')
    {        
       $invocationType = $this->getInvocationType();  
       return ( $invocationType == "RPCInvoke" || $invocationType == "Invoke" );
    }
    
    /**
     * Get invocation type 'RPCInvoke', 'Invoke' or other.
     * 
     * @return string
     */
    public function getInvocationType()
    {
       return (isset($_REQUEST['F']) ? $_REQUEST['F'] : "");
    }
    
    
    public function isRpc()
    {
        
    }
    
    public function getMethodName()
    {
        
    }
    
    public function getObjectName()
    {
        
    }
    
    
}
