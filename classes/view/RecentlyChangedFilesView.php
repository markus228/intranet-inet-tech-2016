<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 30.03.16
 * Time: 17:43
 */

namespace view;


class RecentlyChangedFilesView extends FilesView
{

    public static $NUM_OF_RECENTLY_CHANGED_FILES = 4;

    public function __construct() {
        parent::__construct("files");
    }


    public function getTable() {
        return $this->getFileShare()->getNMostRecentlyChangedFiles(4);
    }


}