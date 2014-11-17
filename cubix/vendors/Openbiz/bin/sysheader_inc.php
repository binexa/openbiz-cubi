<?php
/**
 * Openbiz Framework
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
 * @version   $Id$
 */

include_once("default_consts.php");
include_once("ClassLoader.php");

use Openbiz\Openbiz;
use Openbiz\ClassLoader;


spl_autoload_register(['\Openbiz\ClassLoader', 'autoload']);
// loadCoreClassMap
$coreClassMap = include( __DIR__ . DIRECTORY_SEPARATOR . 'autoload_classmap.php' );
ClassLoader::registerClassMap($coreClassMap);

// loadVendorAutoLoadClassMap
$othersClassMap = include( realpath(__DIR__ . '/../../autoload_classmap_selected.php') );
ClassLoader::registerClassMap($othersClassMap);

register_shutdown_function("bizsystem_shutdown");

function bizsystem_shutdown()
{
    if (isset(Openbiz::$app)) {
        Openbiz::$app->getSessionContext()->saveSessionObjects();
    }
}

//include system message file
include_once(OPENBIZ_PATH . "/messages/system.msg");


// error handling 
error_reporting(E_ALL ^ (E_NOTICE | E_STRICT));

// if use user defined error handling function, all errors are reported to the function
//$default_error_handler = set_error_handler("userErrorHandler");
set_error_handler(array('\Openbiz\Core\ErrorHandler','errorHandler'));
//ErrorHandler::ErrorHandler($errno, $errmsg, $filename, $linenum, $vars);
//$default_exception_handler = set_exception_handler('userExceptionHandler');
set_exception_handler(array('\Openbiz\Core\ErrorHandler','exceptionHandler'));
//ErrorHandler::ExceptionHandler($exc);

// set DOCUMENT_ROOT
setDocumentRoot();

/**
 * Search for the php file required to load the class
 *
 * @package openbiz.bin
 * @param string $className
 * @return void
 * */
function __autoload_openbiz($className)
{
    ClassLoader::autoload($className);
}

/*
 * Set DOCUMENT_ROOT in case the server doesn't have DOCUMENT_ROOT setting (e.g. IIS). 
 * Reference from http://fyneworks.blogspot.com/2007/08/php-documentroot-in-iis-windows-servers.html
 */
function setDocumentRoot()
{
    if (!isset($_SERVER['DOCUMENT_ROOT'])) {
        if (isset($_SERVER['SCRIPT_FILENAME'])) {
            $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
        };
    };
    if (!isset($_SERVER['DOCUMENT_ROOT'])) {
        if (isset($_SERVER['PATH_TRANSLATED'])) {
            $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
        };
    };
}

/**
 *  formatted output given variable by using print_r() function
 *
 *  @author Garbin
 *  @param  any
 *  @return void
 */
function dump($arr, $debug = false)
{
    if ($debug)
        $debug_fun = 'debug_print_backtrace();';
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'print_r($item);' . $debug_fun . ''));
    echo '</pre>';
    exit();
}

/**
 *  formatted output given variable by using var_dump() function
 *
 *  @author Garbin
 *  @param  any
 *  @return void
 */
function vdump($arr, $debug = false)
{
    if ($debug)
        $debug_fun = 'debug_print_backtrace();';
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'var_dump($item);' . $debug_fun . ''));
    echo '</pre>';
    exit();
}
