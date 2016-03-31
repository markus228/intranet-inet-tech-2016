<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 28.12.15
 * Time: 17:05
 */

namespace view;


use helpers\BootstrapAlert;
use view\architecture\View;

class LoginView extends View
{
    private $headerText;
    private $badge;
    private $alerts;

    /**
     * @return BootstrapAlert[]
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @param BootstrapAlert[] $alerts
     */
    public function setAlerts(array $alerts)
    {
        $this->alerts = $alerts;
    }

    /**
     * @return mixed
     */
    public function getHeaderText()
    {
        return $this->headerText;
    }

    /**
     * @param mixed $headerText
     */
    public function setHeaderText($headerText)
    {
        $this->headerText = $headerText;
    }

    /**
     * @return mixed
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param mixed $badge
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }




}