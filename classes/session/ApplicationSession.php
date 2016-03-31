<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 10.01.16
 * Time: 23:39
 */

namespace session;


use Aura\Session\Segment;
use core\Application;
use exceptions\UnauthorizedException;
use helpers\BootstrapAlert;
use models\User;

class ApplicationSession
{

    /**
     * @var User
     */
    private $user;


    public function __construct() {

    }

    /**
     * Leg
     * @param User $user
     */
    public function setUser(User $user) {
        $this->user = $user;
    }

    public function isSessionActive() {
        return !is_null($this->user);
    }

    /**
     * @return User
     * @throws UnauthorizedException
     */
    public function getUser()
    {
        if (is_null($this->user)) throw new UnauthorizedException();
        return $this->user;
    }

    /**
     * Synchronisert Datenbestand mit der Datenbank
     * @throws UnauthorizedException
     */
    private function update() {
        $user = $this->getUser()->getUsername();

        //LastLogin darf nicht aktualisiert werden!
        $lastlog = $this->getUser()->getLastLogin();

        $this->setUser(Application::getApplicationRoot()->getUserDAO()->getUserByUsername($user));

        //Setzt Lastlogin zurück!
        $this->getUser()->setLastLogin($lastlog);

    }

    /**
     * Dieses Objekt wird serialisiert und im Session-Cache abgelegt.
     * Wenn es wieder erwacht, sollte geprüft werden ob neue Daten vorliegen!
     */
    public function __wakeup() {
        if (!$this->isSessionActive()) return;
        $this->update();
    }



}