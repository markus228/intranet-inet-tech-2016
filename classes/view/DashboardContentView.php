<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 25.12.15
 * Time: 17:42
 */

namespace view;


use helpers\BootstrapAlert;
use view\architecture\View;

class DashboardContentView extends View
{
    private $title;
    private $subheading;
    private $alerts;
    private $footer;

    /**
     * Holt den Content der Seite
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Setzt den Content der Seite
     * @param mixed $content
     * @return DashboardContentView
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    private $content;

    /**
     * Holt den Footer der Seite
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Setzt den Footer der Seite
     * @param mixed $footer
     * @return DashboardContentView
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Holt die Unterüberschrift der Seite
     * @return mixed
     */
    public function getSubheading()
    {
        return $this->subheading;
    }

    /**
     * Setzt die Unterüberschrift der Seite
     * @param mixed $subheading
     * @return DashboardContentView
     */
    public function setSubheading($subheading)
    {
        $this->subheading = $subheading;
        return $this;
    }

    /**
     * Holt die Überschrift der Seite
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Setzt die Überschrift der Seite
     * @param mixed $title
     * @return DashboardContentView
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Holt alle Alerts
     * @return mixed
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * Fügt einen Alert hinzu
     * @param $message
     * @param BootstrapAlert $alertType
     * @return string
     */
    public function addAlert($message, BootstrapAlert $alertType) {
        return $this->alerts.=BootstrapAlert::getAlertBox($message, $alertType)."\n";
    }


}