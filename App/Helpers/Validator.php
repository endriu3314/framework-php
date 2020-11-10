<?php

namespace App\Helpers;

use RuntimeException;

class Validator
{
    protected static $types = [
        "array" => "is_array",
        "bool" => "is_bool",
        "boolean" => "is_bool",
        "float" => "is_float",
        "int" => "is_int",
        "integer" => "is_int",
        "null" => "is_null",
        "object" => "is_object",
        "string" => "is_string",

        "file" => "is_file",
        "directory" => "is_dir",

        "url" => [self::class, "isUrl"],
        "ipv4" => [self::class, "isIpv4"],
        "ipv6" => [self::class, "isIpv6"],
        "email" => [self::class, "isEmail"],

        "numeric" => [self::class, "isNumeric"],
        "number" => [self::class, "isNumber"],

        "class" => [self::class, "isClass"],
        "interface" => [self::class, "isInterface"],
        "isTrait" => [self::class, "isTrait"],
    ];

    //TODO: add equal condition
    protected static $conditions = [
        "gt" => [self::class, "greaterThan"],
        "greater_than" => [self::class, "greaterThan"],
        "greaterThan" => [self::class, "greaterThan"],

        "gte" => [self::class, "greaterThanEqual"],
        "greater_than_equal" => [self::class, "greaterThanEqual"],
        "greaterThanEqual" => [self::class, "greaterThanEqual"],

        "bigger" => [self::class, "greaterThan"],
        "bigger_than" => [self::class, "greaterThan"],
        "biggerThan" => [self::class, "greaterThan"],

        "below" => [self::class, "lowerThan"],
        "bel" => [self::class, "lowerThan"],
        "blw" => [self::class, "lowerThan"],

        "sm" => [self::class, "lowerThan"],
        "smaller_than" => [self::class, "lowerThan"],
        "smallerThan" => [self::class, "lowerThan"],

        "below_equal" => [self::class, "lowerThanEqual"],
        "belowEqual" => [self::class, "lowerThanEqual"],
        "bele" => [self::class, "lowerThanEqual"],
        "blwe" => [self::class, "lowerThanEqual"],

        "sme" => [self::class, "lowerThanEqual"],
        "smaller_than" => [self::class, "lowerThanEqual"],
        "smallerThan" => [self::class, "lowerThanEqual"],

        "max" => [self::class, "lowerThan"],
    ];

    protected static $counts = [
        "array" => "count",
        "float" => "number",
        "int" => "number",
        "integer" => "number",
        "string" => "strlen",

        "file" => "filesize",

        "url" => "strlen",
        "ipv4" => "strlen",
        "ipv6" => "strlen",
        "email" => "strlen",

        "numeric" => "number",
        "number" => "number",
    ];

    public static function isNumber($value)
    {
        return is_int($value) || is_float($value);
    }

    public static function isIntegerInString($value)
    {
        if (is_string($value))
            if (preg_match('#^[+-]?[0-9]+$#D', $value))
                return true;

        return false;
    }

    public static function isFloatInString($value)
    {
        if (is_string($value))
            if (preg_match('#^[-+]?\d*\.?\d*$#D', $value))
                return true;

        return false;
    }

    public static function isNumeric($value)
    {
        return is_int($value) || is_float($value) || (is_string($value) && preg_match("#^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$#D", $value));
    }

    public static function isCallable($value)
    {
        return is_callable($value, true);
    }

    public static function isClass($value)
    {
        return class_exists($value);
    }

    public static function isInterface($value)
    {
        return interface_exists($value);
    }

    public static function isTrait($value)
    {
        return trait_exists($value);
    }

    public static function isType($value)
    {
        return self::isClass($value) || self::isInterface($value) || self::isTrait($value);
    }

    public static function isNone($value)
    {
        return $value == null;
    }

    public static function isMail($value)
    {
        if (is_string($value))
            if (preg_match("^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$", $value))
                return true;

        return false;
    }

    public static function isUrl($value)
    {
        if (is_string($value))
            if (preg_match("(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)", $value))
                return true;

        return false;
    }

    public static function isIpv4($value)
    {
        if (is_string($value))
            if (preg_match("^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$", $value))
                return true;

        return false;
    }

    public static function isIpv6($value)
    {
        if (is_string($value))
            if (preg_match("^(?:[A-F0-9]{1,4}:){7}[A-F0-9]{1,4}$", $value))
                return true;

        return false;
    }

    public static function is($value, $rules)
    {
        $rulesArray = explode(",", $rules);
        $type = $rulesArray[0];

        if (count($rulesArray) > 1) {
            if (isset(self::$types[$type])) {
                if (!self::$types[$type]($value))
                    return false;

                $conditions = [];

                foreach ($rulesArray as $key => $ruleValue) {
                    //check if rule is not the type, type should always be first
                    if ($key < 1) continue;

                    $condition = explode(":", $ruleValue);
                    $conditions[$condition[0]] = $condition[1];
                }

                foreach ($conditions as $condition => $conditionValue) {
                    if (isset(self::$conditions[$condition])) {
                        if (!self::$conditions[$condition]($value, $conditionValue, $type))
                            return false;
                    } else {
                        throw new RuntimeException("Condition does not exist");
                    }
                }
            } else {
                throw new RuntimeException("Type does not exist");
            }
        } else {
            if (isset(self::$types[$type])) {
                return self::$types[$type]($value);
            } else {
                throw new RuntimeException("Type does not exist");
            }
        }

        return true;
    }

    public static function greaterThan($value, $minimum, $type)
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) > $minimum)
                return true;
        } else if (self::$counts[$type] === "number") {
            if ($value > $minimum)
                return true;
        }

        return false;
    }

    public static function greaterThanEqual($value, $minimum, $type)
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) >= $minimum)
                return true;
        } else if (self::$counts[$type] === "number") {
            if ($value >= $minimum)
                return true;
        }

        return false;
    }

    public static function lowerThan($value, $maximum, $type)
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) < $maximum)
                return true;
        } else if (self::$counts[$type] === "number") {
            if ($value < $maximum)
                return true;
        }

        return false;
    }

    public static function lowerThanEqual($value, $maximum, $type)
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) <= $maximum)
                return true;
        } else if (self::$counts[$type] === "number") {
            if ($value <= $maximum)
                return true;
        }

        return false;
    }
}
