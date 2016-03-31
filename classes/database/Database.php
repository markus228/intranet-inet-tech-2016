<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 17:14
 */

namespace database;

/**
 * Class Database
 * @package database
 * Erweiterung der bestehenden Datenbankklasse SimplonMysql
 * Sorgt weitesgehende Typenreinheit bei den Rückgabewerten.
 */
class Database extends ExtendedSimplonMysql
{

    /**
     * @return bool|int
     */
    public function getRowCount() {
        return $this->replaceFalseWithEmptyArray(parent::getRowCount());
    }


    /**
     * @param $query
     * @param array $conds
     *
     * @return string
     */
    public function fetchColumn($query, array $conds = array()) {
        return $this->replaceFalseWithEmptyString(parent::fetchColumn($query, $conds));
    }

    /**
     * @param $query
     * @param array $conds
     *
     * @return array
     */
    public function fetchColumnMany($query, array $conds = array()) {
        return $this->replaceFalseWithEmptyArray(parent::fetchColumnMany($query, $conds));
    }

    /**
     * @param $query
     * @param array $conds
     *
     * @return array
     */
    public function fetchRow($query, array $conds = array()) {
        return $this->replaceFalseWithEmptyArray(parent::fetchRow($query, $conds));
    }

    /**
     * @param $query
     * @param array $conds
     *
     * @return array
     */
    public function fetchRowMany($query, array $conds = array()) {
        return $this->replaceFalseWithEmptyArray(parent::fetchRowMany($query, $conds));
    }

    /**
     * @param $tableName
     * @param array $data
     * @param bool $insertIgnore
     *
     * @param string $options
     * @return int
     * @throws \Simplon\Mysql\MysqlException
     */
    public function insert($tableName, array $data, $insertIgnore = false, $options = "") {
        return $this->replaceFalseWithNULL(parent::insert($tableName, $data, $insertIgnore, $options));
    }

    /**
     * @param $tableName
     * @param array $data
     * @param bool $insertIgnore
     *
     * @param string $options
     * @return array|bool
     * @throws \Simplon\Mysql\MysqlException
     */
    public function insertMany($tableName, array $data, $insertIgnore = false, $options = "") {
        return $this->replaceFalseWithEmptyArray(parent::insertMany($tableName, $data, $insertIgnore, $options));
    }

    /**
     * @param $tableName
     * @param array $data
     *
     * @return array|bool
     * @throws MysqlException
     */
    public function replace($tableName, array $data) {
        return $this->replaceFalseWithEmptyArray(parent::replace($tableName, $data));
    }

    /**
     * @param $tableName
     * @param array $data
     *
     * @return array|bool
     * @throws MysqlException
     */
    public function replaceMany($tableName, array $data) {
        return $this->replaceFalseWithEmptyArray(parent::replaceMany($tableName, $data));
    }

    private function replaceFalseWithEmptyArray($data) {
        if ($data === FALSE) return array();
        return $data;
    }

    private function replaceFalseWithEmptyString($data) {
        if ($data === FALSE) return "";
        return $data;
    }

    private function replaceFalseWithNULL($data) {
        if ($data === FALSE) return null;
        return $data;
    }

}