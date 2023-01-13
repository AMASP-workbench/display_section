<?php

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

namespace display_section\classes\traits;

trait constants
{
    /**
     * Get the constants of the further inherited class.
     *
     * @return array
     */
    public static function getConstants(): array
    {
        // "static::class" here does the magic
        try {
            $reflectionClass = new \ReflectionClass(static::class);
            return $reflectionClass->getConstants();

        } catch ( \ReflectionException $e) {
            \LEPTON_tools::display($e->getMessage());
        }
        return [];
    }
}
