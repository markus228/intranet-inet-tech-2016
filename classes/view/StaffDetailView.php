<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.03.16
 * Time: 19:45
 */

namespace view;


use models\User;
use view\architecture\View;

class StaffDetailView extends View
{


    /**
     * @var User
     */
    private $user;


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


    public function isUserSet() {
        return ($this->user instanceof User);
    }





}