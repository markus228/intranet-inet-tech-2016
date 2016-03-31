<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 04.09.15
 * Time: 14:31
 */

namespace helpers;


class BootstrapLabel
{

    public static function _DEFAULT($content) {
        return new BootstrapLabel("label-default", $content);
    }
    public static function _PRIMARY($content) {
        return new BootstrapLabel("label-primary", $content);
    }
    public static function _SUCCESS($content) {
        return new BootstrapLabel("label-success", $content);
    }
    public static function _INFO($content) {
        return new BootstrapLabel("label-info", $content);
    }
    public static function _WARNING($content) {
        return new BootstrapLabel("label-warning", $content);
    }
    public static function _DANGER($content) {
        return new BootstrapLabel("label-danger", $content);
    }


    private $string;
    private $content;

    private function __construct($string, $content) {
        $this->string = $string;
        $this->content = $content;
    }

    public function toString() {
        return '<span class ="label '.$this->string.'">'.$this->content.'</span>';
    }

    public function __toString() {

        return $this->toString();
    }



}