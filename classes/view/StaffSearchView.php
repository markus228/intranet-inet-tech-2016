<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 10:39
 */

namespace view;


use view\architecture\View;

class StaffSearchView extends View
{


    /**
     * @var StaffDetailView
     */
    private $staffDetail;

    /**
     * @return StaffDetailView
     */
    public function getStaffDetail()
    {
        return $this->staffDetail;
    }

    /**
     * @param StaffDetailView $staffDetail
     */
    public function setStaffDetail(StaffDetailView $staffDetail)
    {
        $this->staffDetail = $staffDetail;
    }





}