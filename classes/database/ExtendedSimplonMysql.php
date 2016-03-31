<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 17.08.15
 * Time: 14:41
 */

namespace database;
use Simplon\Mysql\Mysql;
use \Simplon\Mysql\MysqlException;
use Simplon\Mysql\MysqlInterface;

/**
 * Class Mysql
 * @package database
 */
class ExtendedSimplonMysql extends Mysql
{

    public function __construct($host, $user, $password, $database, $fetchMode = \PDO::FETCH_ASSOC, $charset = 'utf8', array $options = array()) {
        parent::__construct($host, $user, $password, $database, $fetchMode, $charset, $options);
    }

    /**
     * @param $tableName
     * @param array $data
     * @param bool $insertIgnore
     *
     * @param string $options
     * @return array|bool
     * @throws MysqlException
     */
    public function insertMany($tableName, array $data, $insertIgnore = false, $options = "")
    {
        if (!isset($data[0]))
        {
            throw new MysqlException("One-dimensional datasets are not allowed. Use 'Mysql::insert()' instead");
        }

        $query = 'INSERT' . ($insertIgnore === true ? ' IGNORE ' : null) . ' INTO ' . $tableName . ' (:COLUMN_NAMES) VALUES (:PARAM_NAMES) '.$options;

        $placeholder = array(
            'column_names' => array(),
            'param_names'  => array(),
        );

        foreach ($data[0] as $columnName => $value)
        {
            $placeholder['column_names'][] = $columnName;
            $placeholder['param_names'][] = ':' . $columnName;
        }

        $query = str_replace(':COLUMN_NAMES', join(', ', $placeholder['column_names']), $query);
        $query = str_replace(':PARAM_NAMES', join(', ', $placeholder['param_names']), $query);

        // ----------------------------------

        $response = $this->prepareInsertReplace($query, $data);

        if (!empty($response))
        {
            return (array)$response;
        }

        return false;
    }


    /**
     * @param $tableName
     * @param array $data
     * @param bool $insertIgnore
     *
     * @param string $options
     * @return bool|int
     * @throws \Simplon\Mysql\MysqlException
     */
    public function insert($tableName, array $data, $insertIgnore = false, $options = "")
    {
        if (isset($data[0]))
        {
            throw new MysqlException("Multi-dimensional datasets are not allowed. Use 'Mysql::insertMany()' instead");
        }

        $response = $this->insertMany($tableName, array($data), $insertIgnore, $options);

        if ($response !== false)
        {
            return array_pop($response);
        }

        return false;
    }






    public function beginTransaction() {
        return $this->getDbh()->beginTransaction();
    }

    public function commit() {
        return $this->getDbh()->commit();
    }

    public function rollBack() {
        return $this->getDbh()->rollBack();
    }

    public function inTransaction() {
        return $this->getDbh()->inTransaction();

    }



}