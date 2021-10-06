<?php

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS  
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.1.10
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

// include secure-system to protect this file and the whole CMS! [2.1]
if (defined('LEPTON_PATH')) {
    \framework\classes\lepton_system::TestFile(__FILE__);
} else {
    for ($i = 0, $root="", $found=false; $i < 7; $root=str_repeat("../", ++$i)."framework/classes/lepton_system.php")
    {
        if (file_exists($root))
        {
            require $root;
            \framework\classes\lepton_system::getInstance(__FILE__);
            $found=true;
            break;
        }
    }
    if($found === false)
    {
        trigger_error(
            sprintf(
                "<p>[ <em>%s</em> ]<br/>Can't include LEPTON_system!</p>",
                filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING),
                E_USER_ERROR
            )
        );
    }
}
// end include secure-system
