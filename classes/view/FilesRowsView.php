<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 15.03.16
 * Time: 20:03
 */

namespace view;


use view\architecture\View;

class FilesRowsView extends View
{

    private $icon;
    private $link;
    private $ajaxLink;
    private $path;
    private $name;
    private $size;
    private $lastChange;
    private $lastChangeHumanReadable;
    private $type;
    private $css_class;

    /**
     * @return mixed
     */
    public function getCssClass()
    {
        return " ".$this->css_class;
    }

    /**
     * @param mixed $css_class
     */
    public function setCssClass($css_class)
    {
        $this->css_class = $css_class;
    }

    /**
     * @return mixed
     */
    public function getAjaxLink()
    {
        return $this->ajaxLink;
    }

    /**
     * @param mixed $ajaxLink
     */
    public function setAjaxLink($ajaxLink)
    {
        $this->ajaxLink = $ajaxLink;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getLastChange()
    {
        return $this->lastChange;
    }

    /**
     * @param $lastChange
     */
    public function setLastChange($lastChange)
    {
        $this->lastChange = $lastChange;
    }

    /**
     * @return mixed
     */
    public function getLastChangeHumanReadable()
    {
        return $this->lastChangeHumanReadable;
    }

    /**
     * @param mixed $lastChangeHumanReadable
     */
    public function setLastChangeHumanReadable($lastChangeHumanReadable)
    {
        $this->lastChangeHumanReadable = $lastChangeHumanReadable;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * Führt den HTML-DOM zurück in eine von PHP verabeitbare Datenstruktur
     * Zwischenschritt zur Aufarbeitung der Tabelle in AJAX
     * @return array
     * @deprecated Aus Effizienzgründen bitte FilesView::toArray() nutzen!
     */
    public function toArray() {
        //HTML Dokument produzieren
        $html = $this->__toString();
        //DOM Parser laden
        $dom = new \DOMDocument();
        //DOM parsen
        $dom->loadXML($html);

        $arr = array();

        //Alle Tabellen Spalten der aktuellen Zeile einlesen
        foreach($dom->getElementsByTagName("td") as $el) {
            /**
             * @var $el \DOMNode
             */

            $arr[] = trim($el->textContent);
        }

        return $arr;
    }





}