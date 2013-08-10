<?php

/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   \
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: index.php 5185 2013-01-19 15:34:13Z hellojixian@gmail.com $
 */
header("Cache-Control: no-cache");
header("Pragma: no-cache");
if (is_file(dirname(__FILE__) . '/files/install.lock')
        && filesize(dirname(__FILE__) . '/files/install.lock') == 1) {
    include 'bin/_forward.php';
} else {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $url = str_replace("index.php", "install/", $script_name);
    echo "<script>location.href='$url'</script>";
    exit;
}

