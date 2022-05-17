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

// include secure-system to protect this file and the whole CMS! [2.3]
if (defined('LEPTON_PATH')) {
    \framework\classes\lepton_system::testFile(__FILE__);
} else {
    ini_set("include_path", "./../../framework/classes/:./../../../framework/classes/:./../../../../framework/classes/:./../../../../../framework/classes/:./../../../../../../framework/classes/:./../../../../../../../framework/classes/:./../../../../../../../../framework/classes/:./../../../../../../../../../framework/classes/");
    spl_autoload("lepton_system");
    if(class_exists("framework\classes\lepton_system"))
    {
        \framework\classes\lepton_system::getInstance(__FILE__);
    } else {
        trigger_error(sprintf(
            "<p>[ <em>%s</em> ]<br/>Can't include LEPTON_system!</p>",
            filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING),
            E_USER_ERROR));
    }
}
// end include secure-system

// Checking Requirements
$PRECHECK['LEPTON_VERSION'] = array(
    'VERSION' => '5.3',
    'OPERATOR' => '>='
);
