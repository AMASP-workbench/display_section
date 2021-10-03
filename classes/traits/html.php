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
    public static $CSS_ATTRIBUTES = [
        'rel'   => "stylesheet",
        'media' => "all"
    ];
    
    /**
     * 
     * @param   array   $attribs    Assoc. array with the attributes.  
     * @return  string  The gemerated (HTML-)link-tag.  
     */
    public static function buildLinkTag( array $attribs=[] ) : string
    {
        $sHTML = "\n<!-- build css-link by trait -->\n<link ";
        
        self::sanitizeCssAtrribs( $attribs );
        
        foreach($attribs as $key => $value)
        {
            $sHTML .= " ".$key."=\"".$value."\"";
        }
        return $sHTML.">\n";
    }
    
    /**
     * 
     * @param   array   $attribs    Assoc. array with the attributes.  
     * @return string   The generated (HTML-)script-tag.  
     */
    public static function buildScriptTag( array $attribs=[] ) : string
    {
        $sHTML = "\n<!-- build by trait -->\n<script ";
        foreach($attribs as $key => $value )
        {
            $sHTML .= " ".$key."=\"".$value."\"";
        }
        return $sHTML."></script>\n";
    }
    
    /**
     * 
     * @param array $attribs
     */
    public static function sanitizeCssAtrribs( array &$attribs=[] )
    {
        foreach(self::$CSS_ATTRIBUTES as $key => $value)
        {
            if(!isset($attribs[ $key ])) {
                $attribs[ $key ] = $value;
            }
        }
    }
}