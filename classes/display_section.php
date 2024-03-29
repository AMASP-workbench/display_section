<?php

declare(strict_types=1);

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.4
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

/**
 * Description of class display_section
 *
 * @author  Dietrich Roland Pehlke (Aldus)
 * @package development
 *
 */
class display_section extends LEPTON_abstract implements display_section\classes\interfaces\environment
{
    use display_section\classes\traits\html;

    /**
     * Is the returned sting an error message or not?
     *
     * @access  public
     * @var bool
     */
    public bool $isError = false;

    /**
     * Holds the handled sectionId
     * @access  public
     * @var     integer Hold the current section id
     *
     */
    public int $iCurrentSectionID = 0;

    /**
     * Should the ID be emphasized in the error messages?
     *
     * @access  public
     * @var     bool
     *
     */
    public bool $emphasizeId = true;

    /**
     * If so: with witch tag (e.g. "em", "strong", "u", or "b")?
     *
     * @access  public
     * @var     string
     */
    public string $emphasizeTag = "strong";

    /**
     * Own instance of this class
     *
     * @access public
     */
    public static $instance = null;

    /**
     *  Required by the abstract class to initialize own values and class-properties
     */
    public function initialize()
    {
        // required by abstract class
    }

    /**
     *
     * Get the content of a given section (ref by ID) and also takes
     * care for the 'headers.inc.php' and //pre-//generated links in the <header>
     * of the page.
     *
     * @param int    $sid           A valid section-id
     * @param string $sPageSource   Call-by-Reference
     *                                  A *Pointer of the page-source (html).
     * @return string   The generated source of the section.
     *
     * @code{.php}
     *      // example
     *      display_section::getInstance()->getSection( 123, $droplet_HTML_source);
     *
     *      // droplet  -> belongs to the section_id 123 in this example
     *      [[display_section?sid=123]]
     * @endcode
     *
     * @global object   $database    Needed for nested/called modules.
     * @global array    $TEXT        Needed for nested/called modules.
     * @global object   $oLEPTON     Needed for nested/called modules.
     * @global integer  $page_id     Needed for nested/called modules.
     * @global integer  $section_id  Needed for nested/called modules.
     * @global array    $HEADERS     Needed for nested/called modules.
     * @global array    $mod_headers Needed for required headers.inc.php.
     *
     */
    public function getSection(int $sid, string &$sPageSource): string
    {
        //  [0] These values are properly used by the called "view" of the called module.
        global $database, $TEXT, $oLEPTON, $page_id, $section_id;

        $HEADERS = &LEPTON_core::$HEADERS;
        $this->isError = false;
        $this->iCurrentSectionID = $sid;

        //  [1] We have at last one char to return by default otherwise droplets will raise an error!
        $section_content = ' ';

        //  [2] Locking for section-values
        $section = [];

        //  [2.1] query for
        LEPTON_database::getInstance()->execute_query(
            "SELECT `section_id`, `module`, `page_id` FROM ".TABLE_PREFIX."sections WHERE `section_id` = ".$sid,
            true,
            $section,
            false
        );

        //  [2.1.1] No section found: we exit the method direct returning an error message here
        if (empty($section)) {
            $this->isError = true;
            if ($this->emphasizeId === true) {
                return sprintf(
                    $this->language["NO_SECTION_FOUND"],
                    "<".$this->emphasizeTag . ">" . $sid . "</" . $this->emphasizeTag . ">"
                );
            }
            return sprintf($this->language["NO_SECTION_FOUND"], $sid);
        }

        //  [2.2]   Section is found
        //  [2.2.1] Prepare some values to "call" the modules-view
        $section_id = $section['section_id'];
        $module     = $section['module'];
        $page_id    = $section['page_id'];

        //  [2.2.2] Start buffering
        ob_start();

        //  [2.2.3] Require the view of the module
        require LEPTON_PATH . self::MODULES_DIR . $module . '/view.php';

        //  [2.2.4] Get the generated content into a var.
        $section_content .= ob_get_contents();

        //  [2.2.5] Try to get the frontend files of the module
        //  [2.2.5.1] Init temporary vars
        $links="\n<!-- display section start [" . $sid . "]-->\n";
        $links_css = "\n<!-- css[-] -->\n";
        $links_js = "\n<!-- js[-] -->\n";

        //  [2.2.6] Is a "headers.inc.php" in the module-directory?
        $sPathToHeaders = self::MODULES_DIR . $module . "/headers.inc.php";
        if (file_exists(LEPTON_PATH . $sPathToHeaders))
        {
            global $mod_headers;

            $links .="\n<!-- headers from [".$module."]-->\n";

            require LEPTON_PATH . $sPathToHeaders;

            //  [2.2.6.1] CSS
            if (isset($mod_headers['frontend']['css']))
            {
                foreach ($mod_headers['frontend']['css'] as $aPathRef)
                {
                    // [2.2.6.1.1] is the link already known? BIG Problem!
                    if (false === $this->findInsideHeadersCSS($aPathRef['file']))
                    {
                        // [2.2.6.1.2] add to $HEADERS to avoid loading the source twice
                        $HEADERS['frontend']['css'][] = [
                            'media' => ($aPathRef['media'] ?? "all"),
                            'file'  => $aPathRef['file']
                        ];

                        $links_css .= self::buildLinkTag([
                                'href'  => LEPTON_URL."/".$aPathRef['file'],
                                'media' => ($aPathRef['media'] ?? "all")
                        ]);
                    }
                }
            }

            //  [2.2.6.2] JS
            if (isset($mod_headers['frontend']['js'])) {
                foreach ($mod_headers['frontend']['js'] as $aPathRef) {
                    // [2.2.6.2.1] Is the link already known?
                    if (!in_array($aPathRef, LEPTON_core::$HEADERS['frontend']['js'])) {
                        $look_up_paths['js'][] = $aPathRef;
                        // [2.2.6.2.1.1] Add link to $HEADERS to avoid loading the source twice
                        $HEADERS['frontend']['js'][] = $aPathRef;

                        // [2.2.6.2.1.2] Build the script-tag
                        $links_js .= self::buildScriptTag([ 'src'   => LEPTON_URL."/".$aPathRef ]);
                    }
                }
            }
        }

        //  Danger! --- Does the current page have the default template or another one?
        //  Therefore: we've to look at "$oLEPTON->page" first!
        $sTempTemplateName = ($oLEPTON->page["template"] == "")
            ? DEFAULT_TEMPLATE
            : $oLEPTON->page["template"]
        ;

        $prefly_look_up_paths = [
            "css" => [
                self::TEMPLATES_DIRNAME . $sTempTemplateName . self::FRONTEND_DIR . $module . "/css/frontend.css",
                self::TEMPLATES_DIRNAME . $sTempTemplateName . self::FRONTEND_DIR . $module . "/frontend.css",
                self::MODULES_DIRNAME . $module . "/css/frontend.css",
                self::MODULES_DIRNAME . $module . "/frontend.css"
            ],
            "js" => [
                self::TEMPLATES_DIRNAME . $sTempTemplateName . self::FRONTEND_DIR . $module . "/js/frontend.js",
                self::TEMPLATES_DIRNAME . $sTempTemplateName . self::FRONTEND_DIR . $module . "/frontend.js",
                self::MODULES_DIRNAME . $module . "/js/frontend.js",
                self::MODULES_DIRNAME . $module . "/frontend.js"
            ]
        ];

        $look_up_paths = [
            'css' => [],
            'js'  => []
        ];

        foreach ($prefly_look_up_paths["css"] as $aPathRef)
        {
            if ((file_exists(LEPTON_PATH . "/" . $aPathRef)) && (false === $this->findInsideHeadersCSS($aPathRef)))
            {
                // add to $HEADERS to avoid loading the source twice
                LEPTON_core::$HEADERS['frontend']['css'][] = [
                        'file'  => $aPathRef,
                        'media' => 'all'
                    ];

                $links_css .= self::buildLinkTag(['href' => LEPTON_URL . "/" . $aPathRef]);
                break; // stop loop
            }
        }

        foreach ($prefly_look_up_paths["js"] as $aPathRef)
        {
            //  is the link allready known?
            if (!in_array($aPathRef, LEPTON_core::$HEADERS['frontend']['js']))
            {
                $look_up_paths['js'][] = $aPathRef;

                // add to $HEADERS to avoid loading the source twice
                LEPTON_core::$HEADERS['frontend']['js'][] = $aPathRef;
            }
        }

        //  [2.3.0] loop through the possible paths ...
        foreach ($look_up_paths as $key=>$files)
        {
            foreach ($files as $f)
            {
                if (true === file_exists(LEPTON_PATH."/".$f))
                {
                    $links .= ($key === "css")
                        ? self::buildLinkTag(['href' => LEPTON_URL . "/" . $f])
                        : self::buildScriptTag(['src' => LEPTON_URL . "/" . $f])
                    ;
                }
            }
        }

        // links zusammenbauen
        $links .= $links_css . $links_js;

        //  [2.4.0]
        $sPageSource = str_replace(
            '</head>',
            $links.'</head>',
            $sPageSource
        );

        // [2.5.0] footer?
        $sFooterSource = $this->getModFooters($module);
        if ($sFooterSource != "")
        {
            $sPageSource = str_replace(
                '</body>',
                $sFooterSource.'</body>',
                $sPageSource
            );
        }

        ob_end_clean();

        //  [3.0]   Pre-Process the content
        $oLEPTON->preprocess($section_content);

        //  [4.0]   Return the content to the "caller".
        return $section_content;
    }

    /**
     *  Loop through $HEADERS['css'] to find a given link here!
     *
     */
    protected function findInsideHeadersCSS(string $sPath = ""): bool
    {
        foreach (LEPTON_core::$HEADERS['frontend']['css'] as $ref)
        {
            if ($ref['file'] === $sPath)
            {
                return true; // found!
            }
        }
        return false; // none match
    }

    /**
     * Try to get the footer.inc.php
     *
     * @global  array   $mod_footers    Used by the required file(-s)
     * @global  array   $FOOTERS        Used by the required file(-s)
     * @param   string  $module         The name of the module/directory
     * @return  string  Generated (HTML-tags)
     */
    public function getModFooters(string $module = ""): string
    {
        // -- 0 Used by the required file(-s)
        global $mod_footers;

        // -- 1
        $sLinksToReturn = "";

        // -- 2
        $sLookUpPath = LEPTON_PATH . self::MODULES_DIR . $module . "/footers.inc.php";

        // -- 3
        if (!file_exists($sLookUpPath))
        {
            return $sLinksToReturn;
        }

        require $sLookUpPath;

        // -- 3.1   We are only interests on js in frontend
        if (isset($mod_footers['frontend']['js']))
        {
            $sLinksToReturn .= "\n<!-- mod_footers of [" . $module . "] -->\n";

            foreach ($mod_footers['frontend']['js'] as $sTempPath)
            {
                if (file_exists(LEPTON_PATH."/".$sTempPath))
                {
                    $sLinksToReturn .= "\n<script src='" . LEPTON_URL . "/" . $sTempPath . "'></script>\n";
                    // 3.1.1
                    LEPTON_core::$FOOTERS['js'][] = $sTempPath;
                }
            }
        }
        return $sLinksToReturn;
    }

    /**
     * Format the (error-) message by a template
     *
     * @param string $sMessage  Call by Reference
     */
    public function formatErrorMessage(string &$sMessage): void
    {
        $oTWIG = lib_twig_box::getInstance();
        $oTWIG->registerModule("display_section", "display_section");

        $sMessage = $oTWIG->render(
            "@display_section/error.lte",
            [
                "section_id" => $this->iCurrentSectionID,
                "message"    => $sMessage
            ]
        );
    }

    /**
     * More or less experimental
     *
     * @global  array   $headers    Need for global access/require.
     * @param   int     $iSectionID Any valid section_id.
     * @return  array
     */
    public static function getHeaderBySection(int $iSectionID = 0): array
    {
        // -- 1
        global $mod_headers, $page_id;
        $mod_headers = [];

        // -- 2
        $sModuleInfo = [];
        LEPTON_database::getInstance()->execute_query(
            "SELECT `module`,`page_id` FROM ".TABLE_PREFIX."sections WHERE section_id=".$iSectionID,
            true,
            $sModuleInfo,
            false
        );

        if (!empty($sModuleInfo))
        {
            // save temp. current page_id
            $old_page_id = $page_id;
            // set page_id of the correspondenting section
            $page_id = $sModuleInfo['page_id'];

            $sLookFileName = LEPTON_PATH . self::MODULES_DIR . $sModuleInfo['module'] . "/headers.inc.php";

            // -- 3
            if (file_exists($sLookFileName))
            {
                require $sLookFileName;
            }
            // restore the current page_id
            $page_id = $old_page_id;
        }
        // -- 4
        return $mod_headers;
    }
}
