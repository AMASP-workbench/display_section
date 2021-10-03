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

namespace display_section\classes\interfaces;

interface environment
{
    /**
     * [1.1.1]  The name of the moduledirectory without leading directory-seperator. 
     * 
     * @access  public
     * @var     string  The name of the moduledirectory without leading directory-seperator.  
     */
    const MODULES_DIRNAME = "modules/";
    
    /**
     * [1.1.2]  Holds the path to the internal modules-directory.
     * 
     * @access  public
     * @var     string  The internal name of the modules-directory with leading directory-seperator.  
     */
    const MODULES_DIR = "/".self::MODULES_DIRNAME;

    /**
     * [1.2.1]  The name of the templates-directory without leading directory-seperator. 
     * 
     * @access  public
     * @var     string  The name of the templates-directory without leading directory-seperator.  
     */    
    const TEMPLATES_DIRNAME = "templates/";
    
    /**
     * [1.3.2]  Holds the path to the internal modules-directory.
     * 
     * @access  public
     * @var     string  The internal name of the modules-directory with leading directory-seperator.  
     */
    const FRONTEND_DIR = "/frontend/";
    
}
