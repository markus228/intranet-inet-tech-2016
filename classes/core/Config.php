<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 28.12.15
 * Time: 18:41
 */

namespace core;

/**
 * Class Config
 * @package core
 *
 * Statische Konfigurationsklasse
 */
abstract class Config
{
    public static $SESSION_SEGMENT = "HTW/Intranet";
    public static $BASE_PATH_FILES = "./userfiles/";

    public static $DB_HOST = "localhost";
    public static $DB_USER = "root";
    public static $DB_PASSWORD = "root";
    public static $DB_DATABASE = "intranet";



}