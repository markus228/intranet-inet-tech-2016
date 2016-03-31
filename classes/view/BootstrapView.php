<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 20.08.15
 * Time: 16:29
 */

namespace view;


use helpers\HTMLHelper;
use router\ApplicationRouter;
use view\architecture\View;


class BootstrapView extends View
{

    private $bodyContent;
    private $contentPastJS;
    private $css;
    private $title;
    private $additionalHeader;
    private $baseUrl;

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        $this->setBaseUrl(ApplicationRouter::getApplicationBaseURL());
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     * @return BootstrapView
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalHeader()
    {
        return $this->additionalHeader;
    }

    /**
     * @param mixed $additionalHeader
     * @return BootstrapView
     */
    public function setAdditionalHeader($additionalHeader)
    {
        $this->additionalHeader = $additionalHeader;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyContent()
    {
        return $this->bodyContent;
    }

    /**
     * @param mixed $bodyContent
     * @return BootstrapView
     */
    public function setBodyContent($bodyContent)
    {
        $this->bodyContent = $bodyContent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentPastJS()
    {
        return $this->contentPastJS;
    }

    /**
     * @param mixed $contentPastJS
     * @return BootstrapView
     */
    protected function setContentPastJS($contentPastJS)
    {
        $this->contentPastJS = $contentPastJS;
        return $this;
    }

    /**
     * @param $contentPastJS
     * @return $this
     */
    public function addContentPastJS($contentPastJS) {
        $this->contentPastJS.=$contentPastJS."\n";
        return $this;
    }

    /**
     * @param $path
     * @return BootstrapView
     */
    public function addAdditionalJScript($path) {
        return $this->addContentPastJS(HTMLHelper::scriptJS($path));
    }

    public function addAdditionalCSS($path) {
        return $this->addContentPastJS(HTMLHelper::linkCss($path));
    }


    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param mixed $css
     * @return BootstrapView
     */
    public function setCss($css)
    {
        $this->css = $css;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return BootstrapView
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Generiert eine Dashboard-Vorlage
     * @param $title
     * @param DashboardContentView $dashboard_content
     * @return BootstrapView
     */
    public static function getDashboard($title, DashboardContentView $dashboard_content) {
        $view = new BootstrapView();
        $view->setTitle($title);
        $view->setCss("dashboard.css");

        $view->setAdditionalHeader(
            HTMLHelper::linkCss("vendor/components/font-awesome/css/font-awesome.min.css")."\n".
            HTMLHelper::linkCss("vendor/datatables/datatables/media/css/dataTables.bootstrap.min.css")."\n".
            HTMLHelper::linkCss("vendor/drmonty/datatables-responsive/css/responsive.bootstrap.min.css")."\n".
            HTMLHelper::linkCss("vendor/components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css")."\n".
            HTMLHelper::linkCss("vendor/components/animate.css/animate.min.css")."\n".
            HTMLHelper::linkCss("vendor/blueimp/jquery-file-upload/css/jquery.fileupload.css")."\n".
            HTMLHelper::linkCss("vendor/lightningtgc/MProgress.js/mprogress.min.css")."\n".
            HTMLHelper::linkCss("vendor/datatables/select/css/select.bootstrap.css")."\n"
            //HTMLHelper::linkCss("vendor/enyo/dropzone/dist/min/dropzone.min.css")."\n"
            ///Applications/MAMP/htdocs/ceval-intern-revamp/vendor/blueimp/jquery-file-upload/css/jquery.fileupload.css
        );

        $view->setContentPastJS(
            HTMLHelper::scriptJS("resources/js/dashboard.js")."\n".
            HTMLHelper::scriptJS("vendor/datatables/datatables/media/js/jquery.dataTables.min.js")."\n".
            HTMLHelper::scriptJS("vendor/datatables/datatables/media/js/dataTables.bootstrap.min.js")."\n".
            HTMLHelper::scriptJS("vendor/drmonty/datatables-responsive/js/dataTables.responsive.min.js")."\n".
            HTMLHelper::scriptJS("vendor/drmonty/datatables-responsive/js/responsive.bootstrap.min.js")."\n".
            HTMLHelper::scriptJS("vendor/components/bootstrap-switch/dist/js/bootstrap-switch.min.js")."\n".
            HTMLHelper::scriptJS("vendor/makeusabrew/bootbox/bootbox.js")."\n".
            HTMLHelper::scriptJS("vendor/rmm5t/jquery-timeago/jquery.timeago.js")."\n".
            HTMLHelper::scriptJS("vendor/rmm5t/jquery-timeago/locales/jquery.timeago.de.js")."\n".
            HTMLHelper::scriptJS("vendor/gagi270683/jQuery-bootstrap/scripts/jquery.bootstrap.newsbox.min.js")."\n".
            HTMLHelper::scriptJS("vendor/mouse0270/bootstrap-growl/bootstrap-notify.min.js")."\n".
            HTMLHelper::scriptJS("vendor/eltimn/jquery-bs-alerts/build/jquery.bsAlerts.min.js")."\n".
            HTMLHelper::scriptJS("vendor/engineersamuel/jquery-filesize/dist/jquery.filesize.min.js")."\n".
            HTMLHelper::scriptJS("vendor/blueimp/jquery-file-upload/js/jquery.iframe-transport.js")."\n".
            HTMLHelper::scriptJS("vendor/blueimp/jquery-file-upload/js/jquery.fileupload.js")."\n".
            HTMLHelper::scriptJS("vendor/lightningtgc/MProgress.js/mprogress.min.js")."\n".
            HTMLHelper::scriptJS("vendor/datatables/select/js/dataTables.select.min.js")."\n"//.
        );


        $dashboard = new DashboardView();

        $dashboard->setDashboardContent($dashboard_content);

        $nav_top = new NavigationTopView();

        $nav_top->setNavbarBrand("firma-Intranet");
        $dashboard->setNavigationTop($nav_top);
        $view->setBodyContent($dashboard);

        return $view;
    }

    /**
     * Generiert eine Login-Seite
     * @param $title
     * @param LoginView $loginView
     * @return BootstrapView
     */
    public static function getLoginPage($title, LoginView $loginView) {
        $view = new BootstrapView();
        $view->setTitle($title);
        $view->setCss("login.css");
        $view->setBodyContent($loginView);

        $view->setAdditionalHeader(
            HTMLHelper::linkCss("vendor/components/font-awesome/css/font-awesome.min.css")."\n"
        );

        $view->setContentPastJS(
            HTMLHelper::scriptJS("resources/js/login.js")."\n"
        );

        return $view;



    }




}