<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

/**
 * Convert class
 *
 * Realiza conversões
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class Convert
{
    /**
     * objectToArray Method
     *
     * Converte Objeto em Array
     * Fonte: https://stackoverflow.com/questions/4345554/convert-a-php-object-to-an-associative-array
     * @param object $obj
     * @param bool $deep
     * @return array
     * @throws \ReflectionException
     */
    public static function objectToArray(object $obj, bool $deep = true)
    {
        $reflectionClass = new \ReflectionClass(get_class($obj));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $val = $property->getValue($obj);
            if (true === $deep && is_object($val)) {
                $val = self::objectToArray($val);
            }
            $array[$property->getName()] = $val;
            $property->setAccessible(false);
        }
        return $array;
    }}