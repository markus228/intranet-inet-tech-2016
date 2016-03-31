<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 01.03.16
 * Time: 21:34
 */

namespace database;


use helpers\BootstrapAlert;

/**
 * Class AlertStack
 * @package database
 *
 * Hält Warnungen für den Nutzer während eines Requests
 */
class AlertStack
{

    /**
     * @var BootstrapAlert[]
     */
    private $alerts = array();

    public function __construct() {

    }

    public function addAlert(BootstrapAlert $alert) {
        $this->alerts[] = $alert;
    }

    /**
     * @return BootstrapAlert[]
     */
    public function getAlerts() {
        return $this->alerts;
    }

}