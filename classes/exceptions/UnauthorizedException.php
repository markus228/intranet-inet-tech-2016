<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 16.01.16
 * Time: 15:45
 */

namespace exceptions;


class UnauthorizedException extends IntranetException
{
    protected $message = "Falscher Benutzername/Passwort";

}