<?php

namespace App\Core;

use App\Core\Helpers\ReflectionHelper;
use App\Core\ORM\Collection;
use App\Core\ORM\QueryGenerator;
use App\Core\ORM\QueryTypes;
use PDO;
use ReflectionClass;

abstract class Model extends Database
{
    protected string $tableName;
    protected string $primaryKey;

    private $stmt;
    private int $queryType;

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
     * Bind parameters to a stmt object
     *
     * @param array $params
     */
    private function bindParamsToStmt(array $params): void
    {
        foreach ($params as $key => $value) {
            $type = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$key}", $value, $type);
        }
    }

    /**
     * Run a query
     *
     * @return array|bool Query result
     */
    private function query(): array | bool
    {
        $query = match($this->queryType) {
            QueryTypes::SELECT => QueryGenerator::generateSelectQuery(
                tableName: $this->tableName,
                dataToSelect: ReflectionHelper::getPublicProperties($this),
                where: $this->where,
                order: $this->order,
                limit: $this->limit
            ),
            QueryTypes::INSERT => QueryGenerator::generateInsertQuery(
                tableName: $this->tableName,
                dataToInsert: ReflectionHelper::getPublicPropertiesValues($this)
            ),
            QueryTypes::UPDATE => QueryGenerator::generateUpdateQuery(
                tableName: $this->tableName,
                dataToUpdate: ReflectionHelper::getPublicPropertiesValues($this),
                where: $this->where
            ),
            QueryTypes::DELETE => QueryGenerator::generateDeleteQuery(),
        };

        switch ($this->queryType) {
            case QueryTypes::INSERT:
            case QueryTypes::UPDATE:
            case QueryTypes::DELETE:
                $this->stmt = $this->conn->prepare($query);
                $this->bindParamsToStmt(ReflectionHelper::getPublicPropertiesValues($this));
                return $this->stmt->execute();
            case QueryTypes::SELECT:
                $this->stmt = $this->conn->query($query);
                $this->bindParamsToStmt(ReflectionHelper::getPublicPropertiesValues($this));
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Construct a query, looks better if you have all()
     * May be useful in the future
     *
     * @return $this
     */
    public function all(): Model
    {
        $this->queryType = QueryTypes::SELECT;
        return $this;
    }

    /**
     * Get first element of a tabel
     *
     * @return \App\Core\Model
     */
    public function first(): Model
    {
        $this->queryType = QueryTypes::SELECT;
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
        $this->queryType = QueryTypes::SELECT;
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
    public function find(mixed $value = null): Model
    {
        if ($value === null) {
            if ($this->{$this->primaryKey} !== null) {
                $value = $this->{$this->primaryKey};
            } else {
                throw new \InvalidArgumentException("Primary key value must be provided");
            }
        } else {
            $this->{$this->primaryKey} = $value;
        }

        $this->queryType = QueryTypes::SELECT;
        $this->where($this->primaryKey, '=', $value)->limit(1);

        $data = $this->query();

        if ($data) {
            ReflectionHelper::setFieldsToReflectionClass($this, $data[0]);
        }

        return $this;
    }

    /**
     * Set query type to insert, creating new
     *
     * @return \App\Core\Model
     */
    public function create(): Model
    {
        $this->queryType = QueryTypes::INSERT;
        return $this;
    }

    /**
     * Set query type to update
     *
     * @return \App\Core\Model
     */
    public function update(): Model
    {
        $this->queryType = QueryTypes::UPDATE;
        return $this;
    }

    /**
     * Execute a query
     *
     * @return \App\Core\ORM\Collection|bool
     */
    public function do(): Collection | bool
    {
        if ($this->queryType === QueryTypes::SELECT) {
            $data = $this->query();

            $items = [];

            foreach ($data as $object) {
                $newClass = clone $this;
                ReflectionHelper::setFieldsToReflectionClass($newClass, $object);
                $items[] = $newClass;
            }

            return new Collection($items);
        }

        if ($this->queryType === QueryTypes::INSERT) {
            return $this->query();
        }

        if ($this->queryType === QueryTypes::UPDATE) {
            if ($this->{$this->primaryKey} == null && $this->where != '') {
                return false;
            }

            $this->where($this->primaryKey, '=', $this->{$this->primaryKey});

            return $this->query();
        }

        if ($this->queryType === QueryTypes::DELETE) {
            return $data;
        }
    }
}
