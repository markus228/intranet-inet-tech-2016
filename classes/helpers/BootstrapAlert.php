<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 31.08.15
 * Time: 11:54
 */

namespace helpers;

/**
 * Class BootstrapAlert
 * @package helpers
 *
 * Helfer-Klasse für Bootstrap Alerts
 */
class BootstrapAlert
{

    public static function SUCCESS($message) {
        return new BootstrapAlert("alert-success", $message);
    }

    public static function INFO($message) {
        return new BootstrapAlert("alert-info", $message);
    }

    public static function WARNING($message) {
        return new BootstrapAlert("alert-warning", $message);
    }

    public static function DANGER($message) {
        return new BootstrapAlert("alert-danger", $message);
    }

    private $message;
    private $type;

    private function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;

    }

    public function toString() {
        return self::getAlertBox($this->message, $this->type);
    }

    public function __toString() {
        return $this->toString();
    }


    public static function getAlertBox($message, $type) {
        $buf =
            '<div class="alert '.$type.' alert-dismissable">'."\n".
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'."\n".
            $message."\n".
            '</div>';

        return $buf;

    }


}

