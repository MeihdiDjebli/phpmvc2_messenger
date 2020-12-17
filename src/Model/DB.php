<?php

namespace App\Model;

use function App\Utils\dump;

/**
 * Class EntityManager
 * @package App\Model
 */
class DB
{
    const HOST = 'db';
    const DBUSER = 'root';
    const DBPASSWORD = 'root';
    const DBDATABASE = 'messenger';

    /**
     * @return \mysqli
     */
    private static function connect(): \mysqli
    {
        return new \mysqli(static::HOST, static::DBUSER, static::DBPASSWORD, static::DBDATABASE);
    }

    /**
     * @param string $query
     * @return bool|\mysqli_result|mixed
     */
    public static function query(string $query)
    {
        $cnx = static::connect();
        $result = $cnx->query($query);
        if (strpos($query, "INSERT") !== false) {
            $result = $cnx->insert_id;
        }
        $cnx->close();
        return $result;
    }
}