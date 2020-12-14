<?php

namespace App\Core\ORM;

class QueryGenerator
{
    /**
     * Generate fields, separate by , or return a *
     * Used in SELECT
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

    /**
     * Generate fields, separated by ,
     * Used in INSERT
     *
     * @param array $dataToInsert Data to insert array ["username" => "endriu3314]
     *
     * @return string
     */
    private static function generateFieldsToInsert(array $dataToInsert = []): string
    {
        $fields = [];

        foreach ($dataToInsert as $field => $value) {
            $fields[] = $field;
        }

        return implode(', ', $fields);
    }

    /**
     * Generate string for values that have to be inserted, with PDO binding
     * Used in INSERT
     *
     * @param array $dataToInsert Data to insert array ["username" => "endriu3314]
     *
     * @return string
     */
    private static function generateValuesToInsert(array $dataToInsert = []): string
    {
        $values = [];

        foreach ($dataToInsert as $key => $value) {
            $values[] = ":{$key}";
        }

        return implode(',', $values);
    }

    private static function generateFieldsAndValuesToUpdate(array $dataToInsert): string
    {
        $params = [];

        foreach ($dataToInsert as $key => $value) {
            $params[] = "${key} = :${key}";
        }

        return implode(', ', $params);
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

    public static function generateInsertQuery(
        string $tableName,
        array $dataToInsert
    ): string {
        $fields = self::generateFieldsToInsert($dataToInsert);
        $values = self::generateValuesToInsert($dataToInsert);
        return "INSERT INTO {$tableName} ({$fields}) VALUES ({$values})";
    }

    public static function generateUpdateQuery(
        string $tableName,
        array $dataToUpdate,
        ?string $where
    ): string {
        $fieldsAndValues = self::generateFieldsAndValuesToUpdate($dataToUpdate);
        return "UPDATE {$tableName} SET ({$fieldsAndValues}) {$where}";
    }
}
