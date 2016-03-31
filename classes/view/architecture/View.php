<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 20.08.15
 * Time: 16:22
 */

namespace view\architecture;


use Aura\Session\Exception;

abstract class View implements ViewInterface
{

    protected $template;
    protected $template_path = "templates/";

    private $map = array();

    /**
     * Konstruiert einen neuen View.
     * Wenn kein
     * @param null $template
     */
    public function __construct($template = null) {
        if (is_null($template)) {
            $class_reflection = new \ReflectionClass(get_class($this));
            $class_name = $class_reflection->getShortName();
            $this->template = $this->translateViewToTemplate($class_name);
        } else {
            $this->template = $template;
        }
    }

    /**
     * Übersetzt den Namen eines Views in den Names des dazugehörigen Templates
     * @param $viewClassName
     * @return string
     * @throws Exception
     * @throws \Exception
     */
    private function translateViewToTemplate($viewClassName) {
        $pos = strpos($viewClassName, "View");
        if ($pos === FALSE) throw new \Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");
        $template = strtolower($viewClassName);
        $template = substr($template, 0, $pos);

        if (empty($template)) throw new Exception("Illegal ViewClassName. Please make sure you adhere to the naming conventions.");

        return $template;
    }

    /**
     * Weißt einem View eine Variable zu.
     * @deprecated
     * @param type $key
     * @param type $value
     */
    protected function assignToView($key, $value) {
        $this->map[$key] = $value;
    }

    /**
     * Ruft einen Wert aus der Tabelle des Views ab.
     * @deprecated
     * @param $key
     * @return string
     */
    public function _($key)
    {
        //Prüfung ist wichtig um auf Entwicklungssystemen Notices zu vermeiden
        if (!array_key_exists($key, $this->map)) {
            return "";
        }

        return $this->map[$key];
    }

    /**
     * Parst das zugehörige Template des Views und gibt das Ergebnis als String zurück.
     * @return string
     * @throws \Exception
     */
    protected function parse() {
        $file = $this->template_path.$this->template.".php";
        if (!file_exists($file)) throw new \Exception ("Laden des Templates $file fehlgeschlagen.");
        //Starte Ausgabe-Puffer
        ob_start();
        //Lade Template (Evaluiert den darin befindlichen PHP-Code im aktuellen Skopus/Zugriff auf $this ist möglich
        include $file;
        //Inhalt des Puffers sichern
        $output = ob_get_contents();
        //Puffer löschen
        ob_end_clean();

        return $output;
    }

    /**
     * Magische __toString Methode, die es ermöglicht das der View direkt mit einem echo/print aufgerufen werden. Implizierter String cast.
     * @return string
     * MAY NOT THROW EXCEPTIONS!
     */
    public function __toString() {
        try {
            return $this->parse();
        } catch (\Exception $e) {
            trigger_error("Exception thrown in __toString() method, which is is not supported. EXCEPTION is converted into FATAL ERROR: EXCEPTION: ".$e->getMessage()." ## For more information on this PHP core related issue, please refer to http://stackoverflow.com/questions/2429642/why-its-impossible-to-throw-exception-from-tostring ", E_USER_ERROR);
            die("-- EXECUTION HALTED --");
        }

    }

}