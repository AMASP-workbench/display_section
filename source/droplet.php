<?php
// First three lines of this file are ignored and can be used to store some information.
// E.g. for an internal version like 0.1.3.23 - 2021-08-28
/**
 *
 *  @version 0.1.8.0
 */
global $database, $TEXT, $oLEPTON, $page_id, $section_id, $HEADERS;

// -- 1 get an instance of the class 
$oDS = display_section::getInstance();

// -- 2 execute 
$sReturnString = $oDS->getSection( $sid ?? 0, $oLEPTON_page_data );

// -- 3 are there any errors?
if(true === $oDS->isError)
{
    // -- 3.1 Format via (TWIG-) template
    $oDS->formatErrorMessage( $sReturnString );
}

// -- 4
return $sReturnString;
