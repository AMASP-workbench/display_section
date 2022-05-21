<?php

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS  
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.1
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if(!defined("SEC_FILE2")) { define("SEC_FILE2","/framework/classes/lepton_system.php"); }
if (defined('LEPTON_PATH'))
{
    \framework\classes\lepton_system::testFile(__FILE__);
} else {
    $a = explode( DIRECTORY_SEPARATOR, __DIR__ ); array_pop($a);
    $n = count($a);
    for($i=0;$i<$n;$i++,array_pop($a)) {
        $fPath = implode(DIRECTORY_SEPARATOR, $a).SEC_FILE2;
        if(file_exists($fPath)) { require_once $fPath; break; }   
    }
    if(class_exists("framework\classes\lepton_system", true)) {
        \framework\classes\lepton_system::getInstance(__FILE__);
    } else {
        trigger_error(sprintf(
            "<p>[ <em>%s</em> ]<br/>Can't include LEPTON_system!</p>",
            filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING),
            E_USER_ERROR));
    }
}