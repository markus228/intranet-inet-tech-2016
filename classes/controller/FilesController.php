<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 08.01.16
 * Time: 10:21
 */

namespace controller;


use core\Config;
use crodas\FileUtil\Path;
use FileUpload\FileUpload;
use models\FileShare;
use models\PathAuth;
use models\User;
use view\BootstrapView;
use view\DashboardContentView;
use view\FilesView;

/**
 * Class FilesController
 * @package controller
 *
 * Controller zur Verarbeitung der Aktionen auf dem Dateissystem
 */
class FilesController extends Controller
{

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function defaultAction()
    {
        $fileShareView = $this->go();

        $content = new DashboardContentView();
        $content->setTitle("Laufwerk");

        $content->setContent($fileShareView);


        $boot = BootstrapView::getDashboard("Privat-Laufwerk", $content);
        $boot->addAdditionalJScript("resources/js/files.js");
        $boot->addAdditionalCSS("resources/css/files.css");

        return $boot;
    }



    /**
     * Allgemeine Methode für AJAX und Web Ansicht, die in einen Order navigiert
     *
     *
     * @return FilesView
     * @throws \exceptions\UnauthorizedException
     * @AuthRequired
     */
    private function go() {

        $user = $this->getUserFromRequest();
        $path = $this->getPathFromRequest($user);


        $fileShare = new FileShare(new PathAuth($user), $path);

        $fileShareView = new FilesView();
        $fileShareView->setFileShare($fileShare);

        return $fileShareView;

    }


    /**
     * Liest die Nutzerdaten aus dem Kontext des aktuellen Requests aus
     * @return User
     * @throws \exceptions\UnauthorizedException
     */
    private function getUserFromRequest() {
        $user = $this->router->getApplicationSession()->getUser();

        return $user;
    }

    /**
     * Liest den Pfad aus dem aktuellen Request aus.
     * Benötigt ein User-Objekt, um den Ordner des Nutzers bestimmen zu können.
     * @param User $user
     * @return mixed|string
     */
    private function getPathFromRequest(User $user) {
        $path = $this->router->getRequestAnalyzer()->getArgument();

        if (empty($path)) {
            $path = Config::$BASE_PATH_FILES.$user->getUsername();
        } else {
            $path = PathAuth::decodePath($path);
        }
        return $path;
    }


    /**
     * Web Go Action
     *
     * @return BootstrapView
     * @AuthRequired
     */
    public function goAction() {
        return $this->defaultAction();
    }

    /**
     * Navigiert zu Ordner und gibt Daten als JSON aus.
     * @return string
     * @AuthRequired
     */
    public function goAjaxAction() {
        $fileShareView = $this->go();

        $encodedSplitPath = array();

        foreach($fileShareView->getCurrentSplitPath() as $key=>$el) {
            $encodedSplitPath[FilesView::$LINK_AJAX_TARGET.PathAuth::encodePath($key)] = $el;
        }

        return json_encode(array("data" => $fileShareView->toArray(), "path" => PathAuth::encodePath($fileShareView->getCurrentPath()), "splitpath" => $encodedSplitPath));

    }

    /**
     * Zeigt eine Datei an
     * @return string
     * @AuthRequired
     */
    public function showAction() {
        $user = $this->getUserFromRequest();
        $path = $this->getPathFromRequest($user);

        $basepath = PathAuth::getBasePath($path);
        $basefile = PathAuth::getBaseFileName($path);

        $fileShare = new FileShare(new PathAuth($user), $basepath);

        $fileShare->getContent($basefile);
    }


    /**
     * Erstellt eine neue leere Datei
     * @return string
     * @throws \Exception
     * @AuthRequired
     */
    public function createFileAction() {
        $user = $this->getUserFromRequest();
        $path = $this->getPathFromRequest($user);

        $fileName = $this->router->getRequestAnalyzer()->getPostRequest()["fileName"];
        $fileShare = new FileShare(new PathAuth($user), $path);

        $fileShare->createFile($fileName);


        return json_encode(array());

    }

    /**
     * Erstellt einen neuen Ordner
     * @return string
     * @throws \Exception
     * @AuthRequired
     */
    public function createFolderAction() {

        $user = $this->getUserFromRequest();
        $path = $this->getPathFromRequest($user);

        $folderName = $this->router->getRequestAnalyzer()->getPostRequest()["folderName"];
        $fileShare = new FileShare(new PathAuth($user), $path);

        $fileShare->createFolder($folderName);

        return json_encode(array());

    }

    /**
     * Verarbeitet die Löschanfrage
     * @return string
     * @throws \Exception
     * @AuthRequired
     */
    public function deleteObjectsAction() {
        $user = $this->getUserFromRequest();
        $toBeDeleted = $this->router->getRequestAnalyzer()->getPostRequest()["objects"];


        //Pfade dekodieren
        foreach($toBeDeleted as &$path) {
            $path = PathAuth::decodePath($path);
        }



        //Prüfen ob alle Dateien im gleichen Pfad liegen und extrahiert dabei die Dateinamen.. Late Night Quicky..
        $dirname = "";
        foreach($toBeDeleted as &$path) {
            $out = pathinfo($path);
            //I know this is hideous...
            if ($dirname != $out["dirname"] && $dirname != "") throw new \Exception("Files must be in the same folder!");
            $dirname = $out["dirname"];
            $path = $out["basename"];
        }

        $fileShare = new FileShare(new PathAuth($user), $dirname);

        foreach($toBeDeleted as $path) {
            $fileShare->deleteObject($path);
        }


        return json_encode(array($toBeDeleted));
    }


    /**
     * Lädt eine Datei hoch
     * @return string
     * @throws \Exception
     * @throws \exceptions\UnauthorizedException
     * @AuthRequired
     */
    public function uploadAction() {

        $user = $this->getUserFromRequest();
        $path = $this->getPathFromRequest($user);

        $auth = new PathAuth($user);


        if (!$auth->isPathValid($path)) throw new \Exception("Invalid Path!");

        // Simple validation (max file size 2MB and only two allowed mime types)
        //$validator = new \FileUpload\Validator\Simple(1024 * 1024 * 2, ['image/png', 'image/jpg']);

        // Alternatively, if you don't want to validate both size and type at the same time, you could use:
        $mimeTypeValidator = new \FileUpload\Validator\MimeTypeValidator(["image/png", "image/jpeg"]);

        // And/or (the 1st parameter is the max size while the 2nd is the min size):
        $validator = new \FileUpload\Validator\SizeValidator("12M", "10KB");

        // Simple path resolver, where uploads will be put
        $pathresolver = new \FileUpload\PathResolver\Simple($path);

        // The machine's filesystem
        $filesystem = new \FileUpload\FileSystem\Simple();

        $uploader = new FileUpload($_FILES['files'], $_SERVER);

        $uploader->setPathResolver($pathresolver);
        $uploader->setFileSystem($filesystem);
        $uploader->addValidator($validator);


        // Doing the deed
        list($files, $headers) = $uploader->processAll();

        // Outputting it, for example like this
        foreach($headers as $header => $value) {
            header($header . ': ' . $value);
        }

        return json_encode(array('files' => $files));

    }

    /**
     * @AuthRequired
     */
    public function unsupportedAction()
    {

    }


}