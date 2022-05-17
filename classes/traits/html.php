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

namespace display_section\classes\traits;

trait html 
{
    /**
     * An array with a set of (css-link) attributes and their default values.  
     * 
     * @var     array
     * @access  public
     * 
     */
    public static $CSS_ATTRIBUTES = [
        "rel"   => "stylesheet",
        "type"  => "text/css",
        "media" => "all"
    ];
    
    /**
     * Generates a (HTML-) link-tag
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
     * Generates a (HTML) script tag.
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
     * Complements an given array of missing (default) entries.
     * 
     * @param array $attribs    An assoc. array of CSS arrtributes. Call by reference.
     * 
     */
    public static function sanitizeCssAtrribs( array &$attribs=[] ) : void
    {
        foreach(self::$CSS_ATTRIBUTES as $key => $value)
        {
            if(!isset($attribs[ $key ])) {
                $attribs[ $key ] = $value;
            }
        }
    }
}