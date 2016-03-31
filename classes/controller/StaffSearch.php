<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 10:36
 */

namespace controller;


use controller\Controller;
use models\EmptyUser;
use models\User;
use view\BootstrapView;
use view\DashboardContentView;
use view\StaffDetailView;
use view\StaffSearchView;

/**
 * Delivers StaffSearch Contents
 *
 * Class StaffSearchController
 * @package controller
 */
class StaffSearchController extends Controller
{

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function defaultAction()
    {

        $staffDetailView = new StaffDetailView();
        $staffDetailView->setUser(EmptyUser::getEmptyUser());

        $staffSearchView = new StaffSearchView();
        $staffSearchView->setStaffDetail($staffDetailView);

        $content = new DashboardContentView();
        $content->setTitle("Personensuche");
        $content->setContent($staffSearchView);


        $bootstrap = BootstrapView::getDashboard("Personensuche", $content);
        $bootstrap->addAdditionalJScript("resources/js/staffSearch.js");
        $bootstrap->addAdditionalCSS("resources/css/staffdetail.css");

        return $bootstrap;
    }

    /**
     * @AuthRequired
     */
    public function searchAction() {
        $searchTerm = $this->router->getRequestAnalyzer()->getPostRequest()["search"];
        $results = $this->router->getApplicationRoot()->getUserDAO()->searchUser($searchTerm);

        echo "search";


    }

    /**
     * @AuthRequired
     */
    public function allUsersAction() {
        $users = $this->router->getApplicationRoot()->getUserDAO()->getAllUsers();

        $user_array = array();

        foreach ($users as $value) {
            $user = $value->toArray();
            $user["name"] = $user["nachname"]. ", ". $user["vorname"];

            $user_array[] = $user;
        }

        return json_encode(array("data" => $user_array));

    }

    public function unsupportedAction()
    {

    }
}