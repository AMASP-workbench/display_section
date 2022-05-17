<?php

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS  
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.0
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
    for($i=0, $root = ""; $i <= 10; $i++, $root .= "../")
    {
        if(file_exists($root.SEC_FILE2))
        {
            require_once $root.SEC_FILE2; break;
        }
    }
    if(class_exists("framework\classes\lepton_system", true))
    { 
        \framework\classes\lepton_system::getInstance(__FILE__);
    } else {
        trigger_error(sprintf(
            "<p>[ <em>%s</em> ]<br/>Can't include LEPTON_system!</p>",
            filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING),
            E_USER_ERROR));
    }
}
// end include class.secure.php
