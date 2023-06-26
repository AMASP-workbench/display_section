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

namespace display_section\classes\interfaces;

interface environment
{
    public const VERSION   = "0.2.0.0";
    /**
     * [1.1.1]  The name of the moduleDirectory without leading directory separator.
     *
     * @access  public
     * @var     string  The name of the moduleDirectory without leading directory-separator.
     */
    public const MODULES_DIRNAME = "modules/";

    /**
     * [1.1.2]  Holds the path to the internal modules-directory.
     *
     * @access  public
     * @var     string  The internal name of the modules-directory with leading directory-separator.
     */
    public const MODULES_DIR = "/".self::MODULES_DIRNAME;

    /**
     * [1.2.1]  The name of the templates-directory without leading directory-separator.
     *
     * @access  public
     * @var     string  The name of the templates-directory without leading directory-separator.
     */
    public const TEMPLATES_DIRNAME = "templates/";

    /**
     * [1.3.2]  Holds the path to the internal modules-directory.
     *
     * @access  public
     * @var     string  The internal name of the modules-directory with leading directory-separator.
     */
    public const FRONTEND_DIR = "/frontend/";
}
