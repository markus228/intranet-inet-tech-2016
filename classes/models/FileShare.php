<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 15.03.16
 * Time: 19:22
 */

namespace models;


use DirectoryIterator;
use helpers\FilePriorityQ;

class FileShare
{

    public static $MKDIR_MODE = 0755;

    private $currentPath;
    private $pathAuth;

    /**
     * @var DirectoryIterator
     */
    private $iterator;


    public function __construct(PathAuth $pathAuth, $currentPath) {
        $this->pathAuth = $pathAuth;
        $this->currentPath = $currentPath;
        if (!$this->pathAuth->isPathValid($currentPath)) throw new \Exception("Path Restriction in effect!");
        $this->initDirectoryIterator();
    }


    /**
     * Initialisisert den Directory Iterator
     */
    private function initDirectoryIterator() {
        try {
            $this->iterator = new DirectoryIterator($this->currentPath);
        } catch(\UnexpectedValueException $e) {
            mkdir($this->currentPath, self::$MKDIR_MODE);
            $this->iterator = new DirectoryIterator($this->currentPath);
        }
    }


    /**
     * Gibt einen Iterator über das angewählte Verzeichnis zurück
     * @return \SplFileInfo[]
     */
    public function listContent() {
        return $this->iterator;
    }

    /**
     * Erstellt einen neuen Ordner
     * @param $folderName
     * @throws \Exception
     */
    public function createFolder($folderName) {
        foreach($this->listContent() as $el) {
            if ($el->getFilename() == $folderName && $el->isDir()) throw new \Exception("Duplicate Folder Exists!");
        }

        //Build new Path
        $pathForNewFolder = $this->currentPath."/".$folderName;
        //Check if new Path would be valid
        if (!$this->pathAuth->isPathValid($pathForNewFolder)) throw new \Exception("Invalid Path");

        //Try making dir
        $ret = mkdir($pathForNewFolder, self::$MKDIR_MODE);

        if ($ret === FALSE) throw new \Exception("Could not create folder");

    }

    /**
     * Erstellt eine leere Datei
     * @param $fileName
     * @throws \Exception
     */
    public function createFile($fileName) {
        foreach($this->listContent() as $el) {
            if ($el->getFilename() == $fileName && $el->isFile()) throw new \Exception("Duplicate File Exists!");
        }

        //Build new Path
        $pathForNewFile = $this->currentPath."/".$fileName;
        if (!$this->pathAuth->isPathValid($pathForNewFile)) throw new \Exception("Invalid Path");
        //Touch the file
        $ret = touch($pathForNewFile, self::$MKDIR_MODE);

        if ($ret === FALSE) throw new \Exception("Could not create file");

    }

    /**
     * Löscht eine Date/Ordner ohne Rückfrage
     * @param $objectName
     * @throws \Exception
     */
    public function deleteObject($objectName) {

        //Build new Path
        $pathForObject = $this->currentPath."/".$objectName;
        if (!$this->pathAuth->isPathValid($pathForObject)) throw new \Exception("Invalid Path");

        self::mjonlirDelete($pathForObject);

    }

    /**
     * Überträgt die Datei an den Client
     * @param $fileName
     * @throws \Exception
     */
    public function getContent($fileName) {
        $path = $this->currentPath."/".$fileName;
        if (!$this->pathAuth->isPathValid($path)) throw new \Exception("Ungültiger Pfad!");
        self::deliverFile($path);
    }

    /**
     * Gibt das PathAuth Objekt zurück
     * @return PathAuth
     */
    public function getPathAuth()
    {
        return $this->pathAuth;
    }

    /**
     * Gibt den aktuellen Pfad zurück
     * @return mixed
     */
    public function getCurrentPath()
    {
        return $this->currentPath;
    }


    /**
     * Holt die N Dateien mit neusten Änderungsdatum
     * @param $n
     * @return \SplFileInfo[]
     */
    public function getNMostRecentlyChangedFiles($n) {
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->currentPath));

        $q = new FilePriorityQ();

        /**
         * @var $obj \SplFileInfo
         */
        foreach($objects as $obj)
        {
            //Keine Ordner
            if ($obj->isDir()) continue;
            //Als Priorität wir die CTime der Datei verwendet
            $q->insert($obj, $obj->getCTime());
        }

        $output = array();

        if ($q->count() < $n) $n = $q->count();

        for($i = 0; $i < $n; $i++) {
            $output[] = $q->extract();
        }

        return $output;
    }


    /**
     * Deliver the file
     * @param $file
     */
    static public function deliverFile($file) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.  urlencode(basename($file)));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        /**
         * Session muss vor Auslieferung geschlossen werden,
         * da das Mutex/Semaphore andernfalls alle anderen Seiten dieser Anwendung während des Downloads blockiert!
         */
        session_write_close();
        readfile($file);
        exit;
    }

    /**
     * Das brutalste Delete aller Zeiten.
     * @source Kudos to Alix Axel
     * @param $path
     * @return bool
     */
    public static function mjonlirDelete($path) {
            if (is_dir($path) === true)
            {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::CHILD_FIRST);

                foreach ($files as $file)
                {
                    if (in_array($file->getBasename(), array('.', '..')) !== true)
                    {
                        if ($file->isDir() === true)
                        {
                            rmdir($file->getPathName());
                        }

                        else if (($file->isFile() === true) || ($file->isLink() === true))
                        {
                            unlink($file->getPathname());
                        }
                    }
                }

                return rmdir($path);
            }

            else if ((is_file($path) === true) || (is_link($path) === true))
            {
                return unlink($path);
            }

            return false;
        }



}