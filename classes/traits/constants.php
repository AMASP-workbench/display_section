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

trait constants
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}