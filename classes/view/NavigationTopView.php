<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 25.12.15
 * Time: 17:08
 */

namespace view;


use view\architecture\View;

class NavigationTopView extends View
{
    private $navbar_brand;

    /**
     * @return mixed
     */
    public function getNavbarBrand()
    {
        return $this->navbar_brand;
    }

    /**
     * @param mixed $navbar_brand
     * @returns Navigation_topView
     */
    public function setNavbarBrand($navbar_brand)
    {
        $this->navbar_brand = $navbar_brand;
        return $this;
    }
}