<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2010-2022 LEPTON Project
 * @link            https://lepton-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 *
 */

namespace display_section\classes\core;

/**
 * NOTICE - this one needs another sec-header block!
 * Current version is

// include secure-system to protect this file and the whole CMS!
if(!defined("SEC_SYSTEM"))
{
    define("SEC_SYSTEM", "/framework/classes/lepton_system.php" );
}
if (defined('LEPTON_PATH'))
{
    \framework\classes\lepton_system::testFile( __FILE__ );
} else {
    $root = "../";
    $level = 1;
    while ( ($level++ < 10) && (!file_exists($root.SEC_SYSTEM)))
    {
        $root .= "../";
    }
    if (file_exists($root.SEC_SYSTEM)) {
        require_once $root.SEC_SYSTEM;
        \framework\classes\lepton_system::getInstance( __FILE__ );
    } else {
        trigger_error(
            sprintf("[ <strong>%s</strong> ] Can't include LEPTON_system!",
                filter_input(INPUT_SERVER,'SCRIPT_NAME', FILTER_SANITIZE_STRING),
                E_USER_ERROR
            )
        );
    }
}
// end include secure-system
 
 */

class lepton_system
{
    /**
     * Error message: access to requested file is not allowed.
     */
    const FILE_ACCESS_NOT_ALLOWED = '<p><strong>ACCESS DENIED! [L5]</strong><br>Invalid call of <em>%s</em></p>';
    
    /**
     * Base path of the installation. (root)
     * 
     * @var string
     */
    public static  $LEPTON_PATH =  "";
    
    /**
     * 
     * @var string
     */
    public string $fileToTest = "";
    
    /**
     * Holds the own instance of this class.
     *  
     * @var instance
     */
    public static $instance = NULL;
    
    /**
     * Holds the full path to the config.php
     * 
     * @access protected
     * @var string
     */
    protected string $config_path = "";
    
    /**
     * Holds the path to the install-file without the basepath.
     * @access protected
     * @var string
     */
    protected string $install_path = "install/index.php";
    
    /**
     * Get the instance of the class
     * 
     * @access public
     * @return instance
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
            static::$instance->initialize(func_get_args());
        }
        return static::$instance;
    }
    
    /**
     * Call comes from getInstance()
     * 
     */
    public function initialize()
    {
        // -- [1]
        self::$LEPTON_PATH = \dirname(\dirname(\dirname(\dirname(__DIR__)))).DIRECTORY_SEPARATOR;
        
        $this->install_path = self::$LEPTON_PATH.$this->install_path;
        
        // -- [2]
        spl_autoload_register(array(__CLASS__, 'autoload'), true, true);
        
        // -- [3]
        $this->fileToTest = func_get_args()[0][0] ?? "";
        
        // -- [4]
        $this->lookForConfig();
        
        // -- [5]
        $this->getLeptonAutoloader();
        
        // -- [6] Test file
        $this->testFileAllowed();
        
        // -- [7]
        $this->loadConfig();
    }
    
    protected function testFileAllowed()
    {
        $oSecure = \LEPTON_secure::getInstance();
        $sLookUpPath = \dirname( $this->fileToTest )."/register_class_secure.php";
        
        if(\file_exists( $sLookUpPath))
        {
            require $sLookUpPath;
        }
        $allowed = $oSecure->testFile( $this->fileToTest );
            
        if(false == $allowed)
        {
            exit(sprintf(
                self::FILE_ACCESS_NOT_ALLOWED,
                filter_input(INPUT_SERVER,'SCRIPT_NAME', FILTER_SANITIZE_STRING)
            ));
        }
    }
    
    public static function testFile( string $aFilePath = "" )
    {
        self::$instance->fileToTest = $aFilePath;
        self::$instance->TestFileAllowed();
    }
    
    /**
     * Autoloader-function
     * 
     * @param string $sClassName
     */
    public static function autoload(string $sClassName)
    {
        // -- [1]
        $aElements = explode("\\", $sClassName);
        $sLookUpPath = self::$LEPTON_PATH.implode( DIRECTORY_SEPARATOR, $aElements).".php";
            
        if (file_exists($sLookUpPath))
        {
            require $sLookUpPath;
        }
    }
    
    public static function getInstallPath()
    {
        return self::getInstance()->install_path;
    }
    
    public static function getConfigPath()
    {
        return self::getInstance()->config_path;
    }
    
    protected function lookForConfig()
    {
        $this->config_path = self::$LEPTON_PATH . "config/config.php";
        if (!\file_exists($this->config_path))
        {
            if (\file_exists($this->install_path ))
            {
                \header("Location: ".$this->install_path);
                exit();
            }
            else
            {
                // Problem: no config.php nor installation files...
                exit('<p><strong>Sorry, but this installation seems to be damaged! Please contact your webmaster!</strong></p>');
            }
        }
    }
    
    /**
     * Try to include the "classic" LEPTON_autoloader
     * 
     */
    protected function getLeptonAutoloader()
    {
        //  1.0 The important parts:
        //  1.1 load and register the LEPTON autoloader
        require_once self::$LEPTON_PATH."framework/functions/function.lepton_autoloader.php";
        spl_autoload_register( "lepton_autoloader", true, true );
    }
    
    /**
     * Try to load the config file of this installation
     */
    protected function loadConfig()
    {
        require_once $this->config_path;
    }
}
