<?php

declare(strict_types=1);

/**
 *  Display Section
 *  An experimental private module for LEPTON-CMS
 *
 *  @package        development
 *  @module         display_section
 *  @version        0.2.2
 *  @author         Dietrich Roland Pehlke (Aldus)
 *  @license        CC BY 3.0
 *  @license_terms  https://creativecommons.org/licenses/by/3.0/
 *
 */

/**
 * Class for install/upgrade module "display_section"
 *
 * @author  Dietrich Roland Pehlke (Aldus)
 * @package development
 *
 */
class display_section_install
{
    public const DROPLET_NAME          = "display_section";
    public const DROPLET_DESCRIPTION   = "An experimental private work";
    public const DROPLET_COMMENT       = "Use: [[display_section?sid=42]]";

    public const DROPLET_SOURCE_FILE   = "/source/droplet.php";

    /**
     *  How many first lines of the php-source of the droplet should be skipped?
     */
    public const DROPLETS_SOURCE_SKIP_LINES = 3;

    public function __construct()
    {
        // [1] Is the droplet installed?
        if (!$this->isInstalled()) {
            // [1.1] Insert an entry in the database
            $this->install();
        } else {
            // [1.2] Upgrade
            $this->upgrade();
        }
    }

    /**
     *  Uninstall and delete entries from DB table
     */
    public static function uninstall(): void
    {
        LEPTON_database::getInstance()->simple_query(
            "DELETE FROM `" . TABLE_PREFIX . "mod_droplets` WHERE `name`='" . self::DROPLET_NAME . "'"
        );
    }

    /**
     * Get the droplet sourcecode.
     *
     * @return string
     */
    protected function getDropletSource(): string
    {
        $aTemp = file(
            dirname(__DIR__) . self::DROPLET_SOURCE_FILE,
            FILE_IGNORE_NEW_LINES
        );

        // Skip first three lines/entries
        return implode("\n", array_slice($aTemp, self::DROPLETS_SOURCE_SKIP_LINES));
    }

    /**
     * Looks inside the db for an entry for the droplet.
     *
     * @return bool
     */
    protected function isInstalled(): bool
    {
        $mixedResult = LEPTON_database::getInstance()->get_one(
            "SELECT `id` FROM `" . TABLE_PREFIX . "mod_droplets` WHERE `name`='" . self::DROPLET_NAME . "'"
        );

        return ($mixedResult !== null);
    }

    /**
     * Insert an entry into the current database.
     *
     * @return int
     */
    protected function install(): int
    {
        return LEPTON_database::getInstance()->build_and_execute(
            "insert",
            TABLE_PREFIX . "mod_droplets",
            [
                "name" => self::DROPLET_NAME,
                "description" => self::DROPLET_DESCRIPTION,
                "comments" => self::DROPLET_COMMENT,
                "code" => $this->getDropletSource(),
                "modified_when" => time(),
                "modified_by" => 1,
                "active" => true,
                "admin_edit" => 1,
                "admin_view" => 1,
                "show_wysiwyg" => 1
            ]
        );
    }

    /**
     * Update an entry inside the current database.
     *
     * @return int
     */
    protected function upgrade(): int
    {
        return LEPTON_database::getInstance()->build_and_execute(
            "update",
            TABLE_PREFIX . "mod_droplets",
            [
                "description" => self::DROPLET_DESCRIPTION,
                "comments" => self::DROPLET_COMMENT,
                "code" => $this->getDropletSource(),
                "modified_when" => time()
            ],
            "`name`='" . self::DROPLET_NAME . "'"
        );
    }
}
