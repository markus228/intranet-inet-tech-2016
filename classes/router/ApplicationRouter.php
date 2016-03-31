<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 10.01.16
 * Time: 23:56
 */

namespace router;


use controller\LoginController;
use core\Application;
use session\ApplicationSession;
use router\Router;
use core\ApplicationRoot;
use Notoj\ReflectionClass;

class ApplicationRouter extends Router
{

    /**
     * @var ApplicationRoot
     */
    private $applicationRoot;
    private static $applicationBaseURL;


    public function __construct(RequestAnalyzer $requestAnalyzer) {
        parent::__construct($requestAnalyzer);
        $this->applicationRoot = Application::getApplicationRoot();

    }

    /**
     * Gibt den Base URL der Anwendung aus
     * @return string
     */
    public static function getApplicationBaseURL()
    {
        if (self::$applicationBaseURL == null) {
            $dir = dirname($_SERVER["SCRIPT_NAME"]);
            if ($dir == "/") $dir = "";
            self::$applicationBaseURL = $dir."/";
        }
        return self::$applicationBaseURL;
    }

    /**
     * Gibt die Wurzel der Anwendung zurück.
     * Enthält wichtige Objekte bspw. DB Zugriff etc
     * @return ApplicationRoot
     */
    public function getApplicationRoot()
    {
        return $this->applicationRoot;
    }

    /**
     * Gibt die Session der Anwendung zurück
     * @return ApplicationSession
     */
    public function getApplicationSession()
    {
        if (!$this->getSessionSegment()->get("intranet") instanceof ApplicationSession) {
            $this->getSessionSegment()->set("intranet", new ApplicationSession());
        }
        return $this->getSessionSegment()->get("intranet");
    }


    /**
     * Callback vor Routing
     */
    protected function preRouting()
    {

    }

    /**
     * Callback nach PostRouting
     */
    protected function postRouting()
    {

    }

    /**
     * Callback vor dem ReRouting
     */
    protected function preReRouting()
    {

    }

    /**
     * Callback nach Routing
     */
    protected function postReRouting()
    {

    }

    /**
     * Callback vor dem Aufruf des Controllers
     * Verarbeitet Annotations
     * @throws \exceptions\ReRouteRequestException
     */
    protected function preRunController()
    {
        $annotations = $this->controller->getControllerAnnotationParser()->getAnnotationsForMethod($this->action);

        if ($annotations->has("AuthRequired")) {
            if (!$this->getApplicationSession()->isSessionActive()) {
                $this->reRouteTo("login", "prompt");
            }
        }

        if ($annotations->has("LogInNotPermitted")) {
            if ($this->getApplicationSession()->isSessionActive()) {
                $this->redirectTo("main");
            }
        }
    }
}