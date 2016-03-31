<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 15.03.16
 * Time: 19:35
 */

namespace models;


class PathAuth
{


    public static $USER_FILES = "./userfiles/";

    /**
     * Codiert einen Pfad
     * @param $path
     * @return string
     */
    public static function encodePath($path) {
        return base64_encode($path);
    }

    /**
     * Dekodiert einen Pfad
     * @param $path
     * @return string
     */
    public static function decodePath($path) {
        $path = preg_replace("/[^a-zA-Z0-9=]+/", "", $path);
        return base64_decode($path);
    }


    /**
     * Zerteilt eine Pfad in seine Stationen
     * @param $path
     * @return array
     * @source Kudos to Yoshi (http://stackoverflow.com/questions/6290146/how-to-split-a-path-properly-in-php)
     */
    public static function splitPath($path) {
        $output = array();
        $chunks = explode('/', $path);
        foreach ($chunks as $i => $chunk) {
                $p = implode('/', array_slice($chunks, 0, $i + 1));
                $output[$p] = $chunk;
        }

        return $output;
    }

    /**
     * Löst ".." in Pfaden auf
     * @param $path
     * @return string
     */
    public static function resolveDoubleDotPath($path) {
        return self::getRealpathNotBoundToFilesystem($path);

    }

    private $user;
    private $paths = array();

    public function __construct(User $user) {
        $this->user = $user;
        $this->addPath(self::$USER_FILES.$user->getUsername());
    }


    /**
     * Fügt einen gültigen Pfad hinzu
     * @param $path
     * @throws \Exception
     */
    public function addPath($path) {
        $path = self::getRealpath($path);
        $this->paths[] = $path;
    }

    /**
     * Gibt alle erlaubten Pfade zurück
     * @return array
     */
    public function getPaths() {
        return $this->paths;
    }


    /**
     * Prüft ob ein Pfad zu den erlaubten Pfaden gehört.
     * @param $path
     * @return bool
     * @throws \Exception
     */
    public function isPathValid($path) {
        foreach ($this->getPaths() as $el) {
            if ($this->isWithinPath($el, $path)) return true;
        }
        return false;
    }


    /**
     * Prüft ob eine gegebener Pfad gleich einer Basis ist
     * @param $path
     * @return bool
     * @throws \Exception
     */
    public function isPathItSelf($path) {
        if ($this->isPathValid($path)) {
            $real = self::getRealpath($path);
            return in_array($real, $this->getPaths());
        }
        return false;
    }

    /**
     * Prüft ob ein gegebener Pfad innerhalb einer einzelnen Basis bleibt
     * @param $base
     * @param $path
     * @return bool
     * @throws \Exception
     */
    private function isWithinPath($base, $path) {
        $length_base_path = strlen($base);
        $cut_str = substr(self::getRealpath($path), 0, $length_base_path);
        if ($cut_str == $base) return true;
        return false;
    }


    /**
     * Wandelt einen relativen Pfad in einen absoluten Pfad um
     *
     * @param $relativePath
     * @return string
     * @throws \Exception
     */
    public static function getRealpath($relativePath) {

        return self::getRealpathNotBoundToFilesystem($relativePath);
        //TODO: Cleanup
        $realpath = realpath($relativePath);
        if ($realpath === FALSE) throw new \Exception("Path does not exist!");
        return $realpath;
    }


    /**
     * Wandelt Pfad um
     * @param $path
     * @return string
     * @source Kudos to waldemar.axdorph@gmail.com
     */
    public static function getRealpathNotBoundToFilesystem($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            //if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }


    /**
     * Gibt zu einer Datei den Verzeichnispfad an.
     * @param $path
     * @return mixed
     */
    public static function getBasePath($path) {
        $out = pathinfo($path);
        return $out["dirname"];
    }


    /**
     * Gibt zu einem Dateipfad den Namen der Datei aus
     */
    public static function getBaseFileName($path) {
        $out = pathinfo($path);
        return $out["basename"];
    }
    
    

}