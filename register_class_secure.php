<?php

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.3
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

$files_to_register = [
    "index.php" ,   // only for testing purpose
    "precheck.php"  // @notice - 2022-01-22: not realy clear if this one is needed here
];

LEPTON_secure::getInstance()->accessFiles($files_to_register);
