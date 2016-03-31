<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 10:26
 */

namespace view;


use helpers\DOMHelper;
use models\FileShare;
use models\PathAuth;
use router\RequestAnalyzer;
use view\architecture\View;

class FilesView extends View
{


    public static $FILE_TYPE_GER = array(
        "file" => "Datei",
        "dir" => "Ordner",
        "link" => "Verknüpfung"
    );

    public static $LINK_AJAX_TARGET = "files/"."goAjax/";

    private $table;
    /**
     * @var FileShare
     */
    private $fileShare;


    /**
     * @return FileShare
     */
    public function getFileShare()
    {
        return $this->fileShare;
    }

    /**
     * Gibt den aktuellen Pfad zurück
     * @return mixed
     */
    public function getCurrentPath() {
        return $this->fileShare->getCurrentPath();
    }


    /**
     * Gibt alle Teilpfade des aktuellen Pfads zurück
     */
    public function getCurrentSplitPath() {
        $paths = PathAuth::splitPath($this->fileShare->getCurrentPath());


        $output = array();

        foreach($paths as $key=>$el) {
            //Ungültige Pfade rauskicken
            if ($this->fileShare->getPathAuth()->isPathItSelf($key)) continue;
            if (!$this->fileShare->getPathAuth()->isPathValid($key)) continue;

            $output[$key] = $el;
        }

        return $output;
    }

    /**
     * @param mixed $fileShare
     */
    public function setFileShare($fileShare)
    {
        $this->fileShare = $fileShare;
    }


    /**
     * @return \SplFileInfo[]
     */
    public function getTable()
    {
        return $this->fileShare->listContent();
    }


    /**
     * Erstellt die Tabelle aus dem Datensatz
     * @return string
     * @throws \Exception
     */
    public function parseTable() {
        $output = "";




        foreach($this->getTable() as $el) {
            $row = new FilesRowsView();
            //Dot Links ignorieren

            if ($el->getFilename() == ".") continue;


            if ($el->isDir()) {
                $row->setIcon("fa fa-folder-o");
                $row->setCssClass("file-folder");
            }

            if ($el->isFile()) {
                $row->setIcon("fa fa-file-o");
                $row->setCssClass("file-file");
            }

            $changeDate = new \DateTime("@".$el->getCTime());

            $row->setLastChange($changeDate->format(\DateTime::ISO8601));
            $row->setLastChangeHumanReadable($changeDate->format("d M y H:i:s"));

            $row->setName($el->getFilename());

            //Dateityp bestimmen
            $typ = (array_key_exists($el->getType(), self::$FILE_TYPE_GER)?self::$FILE_TYPE_GER[$el->getType()]:"Unbekannt");

            $row->setType($typ);

            $row->setSize($el->getSize());


            if ($el->getFilename() == "..") {
                $pathBack = $el->getPath() . "/" . $el->getFilename();


                //Führt der Pfad aus dem Verzeichnis herraus, wird er nicht angezeigt!
                if (!$this->fileShare->getPathAuth()->isPathValid($pathBack)) {
                    continue;
                }

                //Alternativ!
                //$row->setLink("javascript:window.history.back();");
                $row->setLink(RequestAnalyzer::getRedirectURL(
                    "files/".
                    "go/".
                    PathAuth::encodePath(
                        PathAuth::resolveDoubleDotPath($pathBack)
                    )
                )
                );

                $row->setAjaxLink(RequestAnalyzer::getRedirectURL(
                    self::$LINK_AJAX_TARGET.
                    PathAuth::encodePath(
                        PathAuth::resolveDoubleDotPath($pathBack)
                    )
                )
                );

            } else {

                $row->setLink(RequestAnalyzer::getRedirectURL(
                    "files/".
                    ($el->isFile()?"show/":"go/").
                    PathAuth::encodePath(
                        $el->getPath() . "/" . $el->getFilename()
                    )
                )
                );

                $row->setAjaxLink(RequestAnalyzer::getRedirectURL(
                    "files/".
                    ($el->isFile()?"showAjax/":"goAjax/"). //Beachten Konditional/Ternärer Operator ändert URL je nach Dateityp
                    PathAuth::encodePath(
                        $el->getPath() . "/" . $el->getFilename()
                    )
                )
                );

                $row->setPath(
                    PathAuth::encodePath(
                        $el->getPath() . "/" . $el->getFilename()
                    )
                );

            }

            $output.=$row;
        }



        return $output;

    }

    /**
     * @param mixed $table
     */
    private function setTable($table)
    {
        $this->table = $table;
    }


    /**
     * Wandelt Inhalt des Views in Array um, um eine AJAX Ausgabe zu ermöglichen...
     * @return array
     */
    public function toArray() {
        $html = $this->parseTable();
        //Nacktes HTMl muss in einem Container stecken um XML konform zu sein!
        $html = "<container>".$html."</container>";

        $dom = new \DOMDocument();
        $dom->loadXML($html);

        $arr = array();

        //Alle Zeilen extrahieren
        foreach($dom->getElementsByTagName("tr") as $el) {
            $tmpArr = array();
            foreach($el->childNodes as $elChildren) {
                /**
                 * @var $elChildren \DOMNode
                 */
                if ($elChildren->nodeName != "td") continue;
                $tmpArr[] = trim(DOMHelper::DOMinnerHTML($elChildren));
            }
            $arr[] = $tmpArr;
        }

        return $arr;



    }





}