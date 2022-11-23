<?php

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.2
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

// include class.secure.php to protect this file and the whole CMS!
use display_section\classes\core\lepton_system;

if (!defined("SEC_FILE2")) {
    define("SEC_FILE2", "/classes/core/lepton_system.php");
}
if (defined('LEPTON_PATH')) {
    lepton_system::testFile(__FILE__);
} else {
    $a = explode(DIRECTORY_SEPARATOR, __DIR__);
    $n = count($a);
    for ($i = 0; $i < $n; $i++, array_pop($a)) {
        $fPath = implode(DIRECTORY_SEPARATOR, $a) . SEC_FILE2;
        if (file_exists($fPath)) {
            require_once $fPath;
            break;
        }
    }

    if (class_exists("display_section\classes\core\lepton_system")) {
        lepton_system::getInstance(__FILE__);
    } else {
        trigger_error(
            sprintf(
                "<p>[ <em>%s</em> ]<br/>Can't include LEPTON_system!</p>",
                filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_SPECIAL_CHARS)
            ),
            E_USER_ERROR
        );
    }
}
