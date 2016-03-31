<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 16.01.16
 * Time: 15:07
 */

namespace database;


use exceptions\UnauthorizedException;
use models\User;

/**
 * Interface Authenticator
 * @package database
 *
 * Authentifizerungsinterface für Nutzeranmeldung
 */
interface Authenticator
{
    /**
     * @param $user
     * @param $password
     * @throws UnauthorizedException
     */
    function authenticate($user, $password);
    function hasValidCredentials($user, $password);


}