<?php

namespace AndreiCroitoru\FrameworkPhp\Helpers;

class DebugPDO
{
    public static function debugPDO($raw_sql, ?array $parameters): array | string | null
    {
        $keys = [];
        $values = $parameters;

        if ($parameters != null) {
            foreach ($parameters as $key => $value) {
                if (is_string($key)) {
                    $keys[] = '/' . $key . '/';
                } else {
                    $keys[] = '/[?]/';
                }

                if (is_string($value)) {
                    $values[$key] = "'" . $value . "'";
                } elseif (is_array($value)) {
                    $values[$key] = implode(',', $value);
                } elseif (is_null($value)) {
                    $values[$key] = 'NULL';
                }
            }
        }

        echo "<span style='font-weight: bold; color: #121212'>[DEBUG]</span> <span>Keys:</span>" . '<br />';
        $keys == null ? print_r('null') : print_r($keys);
        echo '<br />';
        echo "<span style='font-weight: bold; color: #121212'>[DEBUG]</span> <span>Values:</span>" . '<br />';
        $keys == null ? print_r('null') : print_r($values);
        echo '<br />';

        $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);

        return $raw_sql;
    }
}
