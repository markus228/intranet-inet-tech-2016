<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 25.08.15
 * Time: 09:59
 */

namespace router;


use Aura\Session\Segment;
use Aura\Session\Session;
use Aura\Session\SessionFactory;
use controller\Controller;
use controller\ControllerAnnotationParser;
use exceptions\ReRouteRequestException;
use exceptions\ReRoutingLoopException;
use view\BootstrapView;
use view\ExceptionView;
use core\Config;

/**
 * Achtung. Neue Controller müssen über den Autoloader des Composers zunächst registriert werden,
 * bevor sie im System benutzt werden können!
 * Class Router
 * @package controller\architecture
 */
abstract class Router
{

    /**
     * @var RequestAnalyzer
     */
    private $requestAnalyzer;

    /**
     * @var Controller
     */
    protected $controller;
    /**
     * @var string
     */
    protected $action;

    /**
     * @var Session
     */
    private $session;
    /**
     * @var Segment
     */
    private $sessionSegment;

    private $reRouteStack = array();


    public static $NAMESPACE_CONTROLLER = "controller";
    public static $MAX_HOPS_REROUTE = 20;

    /**
     * @return RequestAnalyzer
     */
    public function getRequestAnalyzer()
    {
        return $this->requestAnalyzer;
    }

    public function __construct(RequestAnalyzer $requestAnalyzer) {
        $this->requestAnalyzer = $requestAnalyzer;
    }


    public function redirectTo($controller = "", $action = "") {
        if (strtolower($controller) == "main" && empty($action)) $controller = "";
        $url = RequestAnalyzer::getRedirectURL($controller, $action);
        header('Location: '.$url, true, 303);
        exit;
    }

    public function reRouteTo($controller, $action) {
        throw new ReRouteRequestException(
            RequestAnalyzer::prependNamespaceAndAppendAppendix(
                RequestAnalyzer::sanitizeRouterInputFirstCap($controller)
            ),
            RequestAnalyzer::appendActionMethodAppendix($action)
        );
    }

    /**
     * Von Markus entwickelte Rerouting Möglichkeit während der Request läuft
     * @throws ReRouteRequestException
     */
    public function rewindAndRestartRouting() {
        $start_controller = $this->reRouteStack[0]["Controller"];
        $start_action = $this->reRouteStack[0]["Action"];
        throw new ReRouteRequestException($start_controller, $start_action);
    }


    /**
     * Regelt die Singalisierung von Ausnahmen
     * @param \Exception $e
     * @return BootstrapView
     */
    protected function exceptionHandler(\Exception $e) {
        $exception = new ExceptionView();
        $exception->setException($e);

        $bootstrap = new BootstrapView();
        $bootstrap->setBodyContent($exception);
        $bootstrap->setTitle("Error 500: Interner Fehler!");
        //return $exception;
        return $bootstrap;

    }


    /**
     * Initialisiert Session
     */
    private function initSession() {
        $sessionFactory = new SessionFactory();
        $this->session = $sessionFactory->newInstance($_COOKIE);
        $this->sessionSegment = $this->session->getSegment(Config::$SESSION_SEGMENT);
    }

    /**
     * @return Segment
     */
    protected function getSessionSegment()
    {
        return $this->sessionSegment;
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * Löst Session auf
     */
    public function destroySession() {
        $this->session->destroy();
    }


    protected abstract function preRouting();
    protected abstract function postRouting();

    protected abstract function preReRouting();
    protected abstract function postReRouting();

    protected abstract function preRunController();


    /**
     * Startet das Routing
     * @return mixed
     * @throws \Exception
     */
    private function performRouting() {
        $this->preRouting();
        //Instanziert den übergebenen Controller

        $this->setControllerAndAction(
            $this->requestAnalyzer->getControllerName(),
            $this->requestAnalyzer->getActionName()
        );

        //Pre-Flight Checks
        $this->postRouting();
    }

    /**
     * Löst ein ReRouting beim laufenden Request aus
     * @param ReRouteRequestException $e
     * @throws \Exception
     */
    private function performReRouting(ReRouteRequestException $e) {

        $this->preReRouting();
        $this->setControllerAndAction(
            $e->getTargetControllerName(),
            $e->getTargetActionName()
        );
        $this->postReRouting();
    }

    /**
     * Setzt Controller und Action
     * @param $controllerName
     * @param $actionName
     * @throws \Exception
     */
    private function setControllerAndAction($controllerName, $actionName) {
        $this->reRouteStack[] = array("Controller" => $controllerName, "Action" => $actionName);
        /*
         * PHP is a really nasty piece of crap
         * Dynamically converting a string into a class name, then allocating memory for the class.
         * Seriously?!
         * Why not. Just go f yourself PHP.
         */
        $this->controller = new $controllerName($this);

        //Sicherheitscheck
        if (!$this->controller instanceof Controller) {
            throw new \Exception("Invalid Controller");
        }

        $this->action = $actionName;

        if (!method_exists($this->controller, $this->action)) {
            throw new \Exception("Invalid Action!");
        }
    }


    /**
     * Führt Action im Controller aus
     * @return mixed
     * @throws \Exception
     */
    private function runController() {
        $this->preRunController();
        if ($this->controller == null) throw new \Exception("Routing not performed! No Controller found!");
        if ($this->action == null) throw new \Exception("Routing not performed! No Action found!");

        $action = $this->action;
        return $this->controller->$action();
    }

    /**
     * Definiert Abbruchedingung beim ReRouting im Routing-Loops zu vermeiden.
     * @return bool
     */
    private function reRoutingLoopCondition() {
        //MAX HOPS
        if (count($this->reRouteStack) > self::$MAX_HOPS_REROUTE) return true;

        return false;
    }

    /**
     * Analysiert den Request und gibt die Ausgabe zurück.
     * Detektiert Count-To-Infinity nach Überschreitung eines threshold.
     * @return BootstrapView
     */
    public function run()
    {
        try {
            $this->initSession();
            $this->performRouting();

            while (!$this->reRoutingLoopCondition()) {
                try {
                    return $this->runController();
                } catch (ReRouteRequestException $e) {
                    //Rerouting requested...
                    $this->performReRouting($e);
                }
            }

            throw new ReRoutingLoopException($this->reRouteStack);

        } catch (\Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            return $this->exceptionHandler($e);
        }
    }

}