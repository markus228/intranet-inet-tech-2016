<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 27.03.16
 * Time: 18:56
 */

namespace models;


class EmptyUser extends User
{

    public function __construct() {
        parent::__construct(null, null, null, null, null, null, null, null, null, null, null, array(), null);
    }

    public static function getEmptyUser() {
        return new EmptyUser();
    }

}