<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 26.12.15
 * Time: 22:09
 */

namespace view;


use models\User;
use view\architecture\View;

class PersoenlicheStatusseiteView extends View
{

    /**
     * @var User
     */
    private $user;
    /**
     * @var RecentlyChangedFilesView
     */
    private $recentlyChangedFilesView;


    public function __construct(User $user) {
        parent::__construct(null);
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return RecentlyChangedFilesView
     */
    public function getRecentlyChangedFilesView()
    {
        return $this->recentlyChangedFilesView;
    }

    /**
     * @param RecentlyChangedFilesView $recentlyChangedFilesView
     */
    public function setRecentlyChangedFilesView($recentlyChangedFilesView)
    {
        $this->recentlyChangedFilesView = $recentlyChangedFilesView;
    }








}