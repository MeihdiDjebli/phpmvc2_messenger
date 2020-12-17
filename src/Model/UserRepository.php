<?php

namespace App\Model;

/**
 * Class UserRepository
 * @package App\Model
 */
class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct("users", "username");
    }

    /**
     * @param User $object
     * @return User|null
     */
    public function insert($object)
    {
        $query = "INSERT INTO %s VALUES (\"%s\", \"%s\", \"%s\")";
        return $this->database::query(
            sprintf($query, $this->table, $object->getUsername(), $object->getPseudo(), $object->getPassword())
        ) !== null
            ? $this->find($object->getUsername())
            : null;
    }

    /**
     * @param User $object
     * @param string $id
     * @return User|null
     */
    public function update($object, $id)
    {
        $query = "UPDATE %s SET username = \"%s\", password = \"%s\", pseudo = \"%s\"";
        return $this->database::query(
            sprintf($query, $this->table, $object->getUsername(), $object->getPseudo(), $object->getPassword())
        )
            ? $this->find($object->getUsername())
            : null;
    }

    /**
     * @param array $data
     * @return User
     */
    protected function convertToObject(array $data): User
    {
        return new User($data['username'], $data['password'], $data['pseudo']);
    }

}