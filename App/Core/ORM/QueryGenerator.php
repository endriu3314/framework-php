<?php

namespace App\Core\ORM;

class QueryGenerator
{
    /**
     * Generate fields, separate by , or return a *
     * Used in SELECT id,name
     *
     * @param array $fields
     *
     * @return string
     */
    private static function generateFieldsToSelect(array $fields = []): string
    {
        $_fields = [];

        if (! empty($fields)) {
            foreach ($fields as $field => $value) {
                $_fields[] = $value;
            }

            return implode(', ', $_fields);
        }

        return "*";
    }

    public static function generateWhereQuery(string $where, string $comparator, string $value): string
    {
        return "{$where} {$comparator} {$value}";
    }

    public static function generateOrderByQuery(string $orderBy, string $orderDirection): string
    {
        if ($orderBy !== '' && $orderDirection !== '') {
            return " ORDER BY {$orderBy} {$orderDirection}";
        }

        return "";
    }

    public static function generateLimitQuery(int $limit): string
    {
        if ($limit !== 0) {
            return " LIMIT {$limit}";
        }

        return '';
    }

    public static function generateSelectQuery(
        string $tableName,
        array $dataToSelect,
        ?string $where = '',
        ?string $order = '',
        ?string $limit = ''
    ): string {
        $fields = self::generateFieldsToSelect($dataToSelect);
        return
            "SELECT {$fields} FROM {$tableName} {$where} {$order} {$limit}";
    }
}
