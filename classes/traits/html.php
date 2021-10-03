<?php

/**
 *  Display Section
 *  An experimental private module
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.1.9
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

namespace display_section\classes\traits;

trait html 
{
    /**
     * 
     * @param array $attribs
     * @return string
     */
    public static function buildLinkTag( array $attribs=[] ) : string
    {
        $sHTML = "\n<link ";
        foreach($attribs as $key => $value)
        {
            $sHTML .= " ".$key."=\"".$value."\"";
        }
        return $sHTML.">\n";
    }
    
}