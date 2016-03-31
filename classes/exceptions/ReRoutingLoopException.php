<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 27.01.16
 * Time: 11:17
 */

namespace exceptions;


class ReRoutingLoopException extends \Exception
{

    /**
     * @var array
     */
    protected $reRouteStack;

    public function __construct(array $reRouteStack) {
        parent::__construct("Rerouting Loop Detected");
        $this->reRouteStack = $reRouteStack;
    }

    /**
     * @return array
     */
    public function getReRoutingStack()
    {
        return $this->reRouteStack;
    }



}