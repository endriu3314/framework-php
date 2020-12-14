<?php

namespace App\Core;

use App\Core\Helpers\ReflectionHelper;
use App\Core\ORM\Collection;
use PDO;
use ReflectionClass;

abstract class Model extends Database
{
    protected string $tableName;
    protected string $primaryKey;

    private $stmt;
    private array $items = [];

    private ReflectionClass $class;
    private string $limit = '';
    private string $order = '';
    private string $where = '';

    public function __construct()
    {
        parent::__construct();
        $this->class = new ReflectionClass($this::class);
        $this->tableName = ReflectionHelper::getPrivatePropertyValue($this, 'tableName');
        $this->primaryKey = ReflectionHelper::getPrivatePropertyValue($this, 'primaryKey');
    }

    /**
     * Add a limit to the query
     *
     * @param int $limit Limit value
     *
     * @return \App\Core\Model
     */
    public function limit(int $limit): Model
    {
        $this->limit = ORM\QueryGenerator::generateLimitQuery($limit);
        return $this;
    }

    /**
     * Add order to the query
     *
     * @param string $by Column to order by
     * @param string $direction Represents the direction of order ASC/DESC
     *
     * @return \App\Core\Model
     */
    public function order(string $by, string $direction = "ASC"): Model
    {
        $this->order = ORM\QueryGenerator::generateOrderByQuery($by, $direction);
        return $this;
    }

    /**
     * Generate where statement or append an existing one
     * Uses AND to append an existing where statement
     *
     * @param string $where
     * @param string $comparator
     * @param string $value
     *
     * @return \App\Core\Model
     */
    public function where(string $where, string $comparator, string $value): Model
    {
        if ($this->where === '') {
            $this->where = "WHERE ";
            $this->where .= ORM\QueryGenerator::generateWhereQuery($where, $comparator, $value);
            return $this;
        }

        $this->where .= " AND ";
        $this->where .= ORM\QueryGenerator::generateWhereQuery($where, $comparator, $value);
        return $this;
    }

    /**
     * Append the where with an OR condition instead of AND
     *
     * @param string $where Field to compare
     * @param string $comparator Comparator used
     * @param string $value Value to compare to
     *
     * @return \App\Core\Model
     */
    public function whereOr(string $where, string $comparator, string $value): Model
    {
        $this->where .= " OR ";
        $this->where .= ORM\QueryGenerator::generateWhereQuery($where, $comparator, $value);
        return $this;
    }

    /**
     * Run a query
     *
     * @return array Query result
     */
    private function query(): array
    {
        $query = ORM\QueryGenerator::generateSelectQuery(
            tableName: $this->tableName,
            dataToSelect: ReflectionHelper::getPublicProperties($this),
            where: $this->where,
            order: $this->order,
            limit: $this->limit,
        );

        $this->stmt = $this->conn->query($query);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Construct a query, looks better if you have all()
     * May be useful in the future
     *
     * @return $this
     */
    public function all(): Model
    {
        return $this;
    }

    /**
     * Get first element of a tabel
     *
     * @return \App\Core\Model
     */
    public function first(): Model
    {
        $this->order($this->primaryKey, 'ASC')->limit(1);

        $data = $this->query();
        ReflectionHelper::setFieldsToReflectionClass($this, $data[0]);

        return $this;
    }

    /**
     * Get last element of a tabel
     *
     * @return \App\Core\Model
     */
    public function last(): Model
    {
        $this->order($this->primaryKey, 'DESC')->limit(1);

        $data = $this->query();
        ReflectionHelper::setFieldsToReflectionClass($this, $data[0]);

        return $this;
    }

    /**
     * Find value by primary key match
     *
     * @param mixed $value Primary key value
     *
     * @return \App\Core\Model
     */
    public function find(mixed $value): Model
    {
        $this->where($this->primaryKey, '=', $value)->limit(1);

        $data = $this->query();
        ReflectionHelper::setFieldsToReflectionClass($this, $data[0]);

        return $this;
    }

    /**
     * Execute a query
     *
     * @return \App\Core\ORM\Collection
     */
    public function do(): Collection
    {
        $data = $this->query();

        $this->items = [];

        foreach ($data as $object) {
            $newClass = clone $this;
            ReflectionHelper::setFieldsToReflectionClass($newClass, $object);
            $this->items[] = $newClass;
        }

        return new Collection($this->items);
    }
}
