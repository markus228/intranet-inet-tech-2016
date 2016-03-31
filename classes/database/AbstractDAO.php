<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 15.03.16
 * Time: 11:51
 */

namespace database;


/**
 * Class AbstractDAO
 * @package database
 *
 * Abstrakte Klasse, die ein Grundgerüst für die DAO Klassen bildet
 */
abstract class AbstractDAO
{

    protected $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

}