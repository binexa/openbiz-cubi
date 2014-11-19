<?php

use Openbiz\ClassLoader;

include_once("ClassLoader.php");

spl_autoload_register(['\Openbiz\ClassLoader', 'autoload']);
// loadCoreClassMap
$coreClassMap = include( __DIR__ . DIRECTORY_SEPARATOR . 'autoload_classmap.php' );
ClassLoader::registerClassMap($coreClassMap);

// loadVendorAutoLoadClassMap
$othersClassMap = include( realpath(__DIR__ . '/../../autoload_classmap_selected.php') );
ClassLoader::registerClassMap($othersClassMap);
