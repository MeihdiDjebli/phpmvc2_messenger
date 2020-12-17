<?php

namespace App\Model;

abstract class AbstractRepository
{
    /**
     * @var string
     */
    protected $primaryField;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DB
     */
    protected $database;

    /**
     * AbstractRepository constructor.
     * @param string $table
     * @param string $primaryField
     */
    public function __construct(string $table, string $primaryField)
    {
        $this->database = new DB();
        $this->table = $table;
        $this->primaryField = $primaryField;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function find($id)
    {
        $query = "SELECT * FROM %s WHERE %s = %s";
        $idInQuery = is_int($id) ? $id : sprintf('"%s"', $id);
        $data = $this->database::query(sprintf($query, $this->table, $this->primaryField, $idInQuery));
        return $data->num_rows === 1 ? $this->convertToObject($data->fetch_assoc()) : null;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM %s";
        $results = $this->database::query(sprintf($query, $this->table));
        if ($results === false) {
            throw new \Exception("No results !");
        }
        return $this->converToObjects($results->fetch_all(MYSQLI_ASSOC));
    }

    /**
     * @param $object
     * @return mixed
     */
    abstract public function insert($object);

    /**
     * @param $object
     * @param $id
     * @return mixed
     */
    abstract public function update($object, $id);

    /**
     * @param array $datas
     * @return array
     */
    protected function converToObjects(array $datas): array
    {
        return array_map(function (array $data) { return $this->convertToObject($data); }, $datas);
    }

    /**
     * @param array $data
     * @return mixed
     */
    abstract protected function convertToObject(array $data);
}