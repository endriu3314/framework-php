<?php

namespace App\Core\Helpers;

use App\Core\Exceptions\ValidatorException;

/**
 * Class Validator
 * Used to validate data.
 */
class Validator
{
    /**
     * Array of existing types, PHP or custom ones
     * For each key that represents a type there is a function that checks that type.
     *
     * @var array
     */
    protected static $types = [
        'array'   => 'is_array',
        'bool'    => 'is_bool',
        'boolean' => 'is_bool',
        'float'   => 'is_float',
        'int'     => 'is_int',
        'integer' => 'is_int',
        'null'    => 'is_null',
        'object'  => 'is_object',
        'string'  => 'is_string',

        'file'      => 'is_file',
        'directory' => 'is_dir',

        'url'   => [self::class, 'isUrl'],
        'ipv4'  => [self::class, 'isIpv4'],
        'ipv6'  => [self::class, 'isIpv6'],
        'email' => [self::class, 'isEmail'],

        'numeric' => [self::class, 'isNumeric'],
        'number'  => [self::class, 'isNumber'],

        'class'     => [self::class, 'isClass'],
        'interface' => [self::class, 'isInterface'],
        'isTrait'   => [self::class, 'isTrait'],

        'date'     => [self::class, 'isDate'],
        'dateTime' => [self::class, 'isDateTime'],
    ];

    /**
     * Custom conditions for validations
     * Each key is an alias, it's value pointing to the function inside the class
     * Because it's a static class we use an array to give the class.
     *
     * @example gt:6, max:10
     *
     * @var string[]
     */
    protected static $conditions = [
        'gt'           => [self::class, 'greaterThan'],
        'greater_than' => [self::class, 'greaterThan'],
        'greaterThan'  => [self::class, 'greaterThan'],

        'gte'                => [self::class, 'greaterThanEqual'],
        'greater_than_equal' => [self::class, 'greaterThanEqual'],
        'greaterThanEqual'   => [self::class, 'greaterThanEqual'],

        'bigger'      => [self::class, 'greaterThan'],
        'bigger_than' => [self::class, 'greaterThan'],
        'biggerThan'  => [self::class, 'greaterThan'],

        'below' => [self::class, 'lowerThan'],
        'bel'   => [self::class, 'lowerThan'],
        'blw'   => [self::class, 'lowerThan'],

        'sm'           => [self::class, 'lowerThan'],
        'smaller_than' => [self::class, 'lowerThan'],
        'smallerThan'  => [self::class, 'lowerThan'],

        'below_equal' => [self::class, 'lowerThanEqual'],
        'belowEqual'  => [self::class, 'lowerThanEqual'],
        'bele'        => [self::class, 'lowerThanEqual'],
        'blwe'        => [self::class, 'lowerThanEqual'],

        'sme'                => [self::class, 'lowerThanEqual'],
        'smaller_than_equal' => [self::class, 'lowerThanEqual'],
        'smallerThanEqual'   => [self::class, 'lowerThanEqual'],

        'max' => [self::class, 'lowerThan'],

        'eq'    => [self::class, 'equal'],
        'equal' => [self::class, 'equal'],
    ];

    /**
     * Array of functions to count
     * Each array key represents a type and the value it's the function you use to count it
     * Used for comparing.
     *
     * @var string[]
     */
    protected static $counts = [
        'array'   => 'count',
        'float'   => 'number',
        'int'     => 'number',
        'integer' => 'number',
        'string'  => 'strlen',

        'file' => 'filesize',

        'url'   => 'strlen',
        'ipv4'  => 'strlen',
        'ipv6'  => 'strlen',
        'email' => 'strlen',

        'date'     => 'compareDate',
        'dateTime' => 'compareDate',

        'numeric' => 'number',
        'number'  => 'number',
    ];

    /**
     * Function used to determine if the input is either integer or float type.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isNumber($value): bool
    {
        return is_int($value) || is_float($value);
    }

    /**
     * Function used to determine if a string is an integer.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isIntegerInString($value): bool
    {
        if (is_string($value)) {
            if (preg_match('#^[+-]?[0-9]+$#D', $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Function used to determine if a string is a float.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isFloatInString($value): bool
    {
        if (is_string($value)) {
            if (preg_match('#^[-+]?\d*\.?\d*$#D', $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Function used to determine if the input is either an integer, float or a string representing a number.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isNumeric($value): bool
    {
        return is_int($value) || is_float($value) || (is_string($value) && preg_match('#^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$#D', $value));
    }

    /**
     * Checks if a function is callable.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isCallable($value): bool
    {
        return is_callable($value, true);
    }

    /**
     * Check if the input is a class.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isClass($value): bool
    {
        return class_exists($value);
    }

    /**
     * Check if the input represents an interface.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isInterface($value): bool
    {
        return interface_exists($value);
    }

    /**
     * Check if the input is a trait.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isTrait($value): bool
    {
        return trait_exists($value);
    }

    /**
     * Check if the input is either a class, interface or trait.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isType($value): bool
    {
        return self::isClass($value) || self::isInterface($value) || self::isTrait($value);
    }

    /**
     * Check if the input is null/0/false/empty string.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isNone($value): bool
    {
        return $value == null;
    }

    /**
     * Check if the input is a valid email.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isMail($value): bool
    {
        if (is_string($value)) {
            if (preg_match("^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$", $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the input is an url.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isUrl($value): bool
    {
        if (is_string($value)) {
            if (preg_match("(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)", $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the input is an IPv4.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isIpv4($value): bool
    {
        if (is_string($value)) {
            if (preg_match("^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$", $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the input is an IPv6.
     *
     * @param $value - Input to validate
     *
     * @return bool
     */
    public static function isIpv6($value): bool
    {
        if (is_string($value)) {
            if (preg_match('^(?:[A-F0-9]{1,4}:){7}[A-F0-9]{1,4}$', $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the input is a Date.
     *
     * @param mixed  $value
     * @param string $format Default value is Y-m-d
     *
     * @return bool
     */
    public static function isDate($value, string $format = 'Y-m-d'): bool
    {
        $dt = \DateTime::createFromFormat($format, $value);

        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    /**
     * Check if the input is a DateTime.
     *
     * @param mixed  $value
     * @param string $format Default value is Y-m-d H:i:s
     *
     * @return bool
     */
    public static function isDateTime($value, string $format = 'Y-m-d H:i:s'): bool
    {
        $dt = \DateTime::createFromFormat($format, $value);

        return $dt !== false && !array_sum($dt::getLastErrors());
    }

    /**
     * General function to implement all checks.
     *
     * @example Validator::is(1, "int,gt:6")
     *
     * @param $value - Input to validate
     * @param $rules - Rules to validate
     *
     * @return bool
     */
    public static function is($value, $rules): bool
    {
        $rulesArray = explode(',', $rules);
        $type = $rulesArray[0];

        if (count($rulesArray) > 1) {
            if (isset(self::$types[$type])) {
                if (!self::$types[$type]($value)) {
                    return false;
                }

                $conditions = [];

                foreach ($rulesArray as $key => $ruleValue) {
                    //check if rule is not the type, type should always be first
                    if ($key < 1) {
                        continue;
                    }

                    $condition = explode(':', $ruleValue);
                    $conditions[$condition[0]] = $condition[1];
                }

                foreach ($conditions as $condition => $conditionValue) {
                    if (isset(self::$conditions[$condition])) {
                        if (!self::$conditions[$condition]($value, $conditionValue, $type)) {
                            return false;
                        }
                    } else {
                        throw new ValidatorException('Condition does not exist');
                    }
                }
            } else {
                throw new ValidatorException('Type does not exist');
            }
        } else {
            if (isset(self::$types[$type])) {
                return self::$types[$type]($value);
            } else {
                throw new ValidatorException('Type does not exist');
            }
        }

        return true;
    }

    /**
     * Function to check if a type is bigger than a value (>)
     * It uses the counting array to check the function it uses to count.
     *
     * @param $value - Value to check
     * @param $minimum - Value to be checked with
     * @param $type - Type of value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function greaterThan($value, $minimum, $type): bool
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) > $minimum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'number') {
            return $value > $minimum;
        } elseif (self::$counts[$type] === 'compareDate') {
            $date1 = new \DateTime($value);
            $date2 = new \DateTime($minimum);

            return $date1 > $date2;
        }

        return false;
    }

    /**
     * Function to check if a type is bigger than a value (>=)
     * It uses the counting array to check the function it uses to count.
     *
     * @param $value - Value to check
     * @param $minimum - Value to be checked with
     * @param $type - Type of value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function greaterThanEqual($value, $minimum, $type): bool
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) >= $minimum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'number') {
            if ($value >= $minimum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'compareDate') {
            $date1 = new \DateTime($value);
            $date2 = new \DateTime($minimum);

            return $date1 >= $date2;
        }

        return false;
    }

    /**
     * Function to check if a type is bigger than a value (<)
     * It uses the counting array to check the function it uses to count.
     *
     * @param $value - Value to check
     * @param $maximum - Value to be checked with
     * @param $type - Type of value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function lowerThan($value, $maximum, $type): bool
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) < $maximum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'number') {
            if ($value < $maximum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'compareDate') {
            $date1 = new \DateTime($value);
            $date2 = new \DateTime($maximum);

            return $date1 < $date2;
        }

        return false;
    }

    /**
     * Function to check if a type is bigger than a value (<=)
     * It uses the counting array to check the function it uses to count.
     *
     * @param $value - Value to check
     * @param $maximum - Value to be checked with
     * @param $type - Type of value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function lowerThanEqual($value, $maximum, $type): bool
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) <= $maximum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'number') {
            if ($value <= $maximum) {
                return true;
            }
        } elseif (self::$counts[$type] === 'compareDate') {
            $date1 = new \DateTime($value);
            $date2 = new \DateTime($maximum);

            return $date1 <= $date2;
        }

        return false;
    }

    /**
     * Function to check if a type is bigger than a value (===)
     * It uses the counting array to check the function it uses to count.
     *
     * @param $value - Value to check
     * @param $equal - Value to be checked with
     * @param $type - Type of value
     *
     * @throws \Exception
     *
     * @return bool
     */
    public static function equal($value, $equal, $type): bool
    {
        if (function_exists(self::$counts[$type])) {
            if (self::$counts[$type]($value) <= $equal) {
                return true;
            }
        } elseif (self::$counts[$type] === 'number') {
            if ($value == $equal) {
                return true;
            }
        } elseif (self::$counts[$type] === 'compareDate') {
            $date1 = new \DateTime($value);
            $date2 = new \DateTime($equal);

            return $date1 == $date2;
        }

        return false;
    }
}
