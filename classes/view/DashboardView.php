<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 21.08.15
 * Time: 10:24
 */

namespace view;

use view\architecture\View;

class DashboardView extends View
{

    private $navigation_top;
    private $dashboard_content;

    /**
     * @return mixed
     */
    public function getDashboardContent()
    {
        return $this->dashboard_content;
    }

    /**
     * @param mixed $dashboard_content
     * @return DashboardView
     */
    public function setDashboardContent(DashboardContentView $dashboard_content)
    {
        $this->dashboard_content = $dashboard_content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNavigationTop()
    {
        return $this->navigation_top;
    }

    /**
     * @param mixed $navigation_top
     * @return DashboardView
     */
    public function setNavigationTop(NavigationTopView $navigation_top)
    {
        $this->navigation_top = $navigation_top;
        return $this;
    }




}