<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 25.08.15
 * Time: 14:10
 */

namespace view;


use view\architecture\View;

class ExceptionView extends View
{

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @param mixed $exception
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function getExceptionName() {
        return get_class($this->exception);
    }

    public function getExceptionMessage() {
        return $this->exception->getMessage();
    }

    public function getExceptionCode() {
        return $this->exception->getCode();
    }

    public function getDevsInformation() {
        return
            "<b>Code:</b> ".$this->exception->getCode().
            "<br><b>File:</b> ".$this->exception->getFile().
            "<br><b>Line:</b> ".$this->exception->getLine().
            "<br> <b>Stacktrace: </b>".
            "<pre>".$this->exception->getTraceAsString().
            "</pre>"
            ;
    }

}