<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.01.16
 * Time: 18:58
 */

namespace router;


class RequestAnalyzer implements ControllerAndActionProvider
{



    private $get_request;
    private $post_request;
    private $request_method;
    private $post_files;


    private $controllerName;
    private $actionName;
    private $argument;


    public static $NAMESPACE_CONTROLLER = "controller";

    public function __construct($get_request, $post_request, $request_method, $post_files) {
        $this->get_request = $get_request;
        $this->post_request = $post_request;
        $this->request_method = $request_method;
        $this->analyze();

    }

    /**
     * Gibt das Argument zurück
     * @return mixed
     */
    public function getArgument()
    {
        return $this->argument;
    }


    /**
     * Gibt alle GET Parameter zurück
     * @return mixed
     */
    public function getGetRequest()
    {
        return $this->get_request;
    }

    /**
     * Gibt alle POST-Paramenter zurück
     * @return mixed
     */
    public function getPostRequest()
    {
        return $this->post_request;
    }

    /**
     * Gibt alle FILE Parameter zurück
     * @return mixed
     */
    public function getPostFiles()
    {
        return $this->post_files;
    }

    /**
     * Gibt die Anfrage Art zurück
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $this->request_method;
    }


    /**
     * Bereinigt den Controller/Action Parameter und setzt den ersten Buchstaben als Großbuchstaben
     * @param $input
     * @return string
     */
    public static function sanitizeRouterInputFirstCap($input) {
        return ucfirst(self::sanitizeRouterInput($input));
    }

    /**
     * Bereinigt den Controller/Action Parameter
     * @param $input
     * @return mixed
     */
    public static function sanitizeRouterInput($input) {
        return preg_replace("/[^a-zA-Z]+/", "", $input);
    }


    /**
     * Hängt den Controller-Namespace vor den Controller Namen und hängt "Controller" an
     * @param $class
     * @return string
     */
    public static function prependNamespaceAndAppendAppendix($class) {
        $class = "\\".self::$NAMESPACE_CONTROLLER."\\".$class."Controller";
        return $class;
    }


    /**
     * Hängt Action Appendix an Action Paramter an
     * @param $method
     * @return string
     */
    public static function appendActionMethodAppendix($method) {
        return $method."Action";
    }

    /**
     * Gibt den Controller Namen zurück
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * Gibt den Action Namen zurück
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Ermittelt die Redirect URL
     * @param $controller
     * @param string $action
     * @return string
     * @throws \Exception
     */
    public static function getRedirectURL($controller, $action = "") {
        if (empty($controller)) {
            if (empty($action)) {
                return ApplicationRouter::getApplicationBaseURL();
            } else {
                throw new \Exception("Invalid Controller/Action!");
            }
        }
        return $controller."/".$action;
    }


    /**
     * Analysiert die Anfrage des Clients
     */
    private function analyze() {
        //Aus Query die Parameter bestimmen
        $controller = self::sanitizeRouterInputFirstCap(isset($this->get_request["controller"])?$this->get_request["controller"]:"");
        $action = self::sanitizeRouterInputFirstCap(isset($this->get_request["action"])?$this->get_request["action"]:"");
        $argument = isset($this->get_request["argument"])?$this->get_request["argument"]:"";

        //Namespace an Controller hängen und Action ergänzen.
        $controller = self::prependNamespaceAndAppendAppendix($controller);
        $action = self::appendActionMethodAppendix($action);

        //Prüfen ob Controller im Namespace existiert...
        if (!class_exists($controller) || $controller == "\\controller\\Controller") {
            $controller = self::prependNamespaceAndAppendAppendix("Unknown");
        }

        //Prüfen ob Action im gewählten Controller existiert...
        if (!method_exists($controller, $action) && $action != "Action") {
            $action = self::appendActionMethodAppendix("unsupported"); //Action exisitiert nicht
        } elseif ($action == "Action") {
            $action = self::appendActionMethodAppendix("default"); //Keine Action angegeben
        }

        $this->controllerName = $controller;
        $this->actionName = $action;
        $this->argument = $argument;

    }

}