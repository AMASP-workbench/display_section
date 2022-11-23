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
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstants(): array
    {
        // "static::class" here does the magic
        try {
            $reflectionClass = new \ReflectionClass(static::class);
            if (!$reflectionClass) {
                throw new \ReflectionException("Cannot get reflection!", 12345);
            } else {
                return $reflectionClass->getConstants();
            }
        } catch ( \ReflectionException $e) {
            \LEPTON_tools::display($e->getMessage());
        }
        return [];
    }
}
