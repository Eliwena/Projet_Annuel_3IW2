<?php

namespace App\Controller\Admin\Review;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Models\Review\Report;
use App\Models\Review\ReviewMenu;
use App\Repository\Review\ReportRepository;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Http\Cache;
use App\Services\Http\Message;
use App\Services\User\Security;

class ReportController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

    public function indexAction(){
        $this->isGranted('admin_panel_report_list');

        $reports = ReportRepository::getReport();
        $this->render("admin/report/list", ['reports' => $reports], 'back');
    }

    public function showAction() {
        $this->isGranted('admin_panel_report_show');

        if(isset($_GET['id'])) {
            $report = ReportRepository::getReport($_GET['id']);
            if($report) {
                $this->render("admin/report/show", ['report' => $report], 'back');
            } else {
                Message::create('Error', 'Commentaire existe pas');
                $this->redirect(Framework::getUrl('app_admin_report'));
            }
        } else {
            Message::create('Error', 'Identifiant introuvable');
            $this->redirect(Framework::getUrl('app_admin_report'));
        }
    }

    public function deleteAction() {
        $this->isGranted('admin_panel_report_delete');

        if(isset($_GET['id'])) {
            $review = ReviewRepository::getReviewById($_GET['id']);

                //init data
                $reviewMenus = ReviewMenuRepository::getReviewMenus($review);
                $reports = ReportRepository::getReportByReviewId($review);
                $review->setUserId(null);
                //delete all reviewmenu associate
                if($reviewMenus) {
                    foreach ($reviewMenus as $reviewMenu) {
                        $rm = new ReviewMenu();
                        $rm->setId($reviewMenu['id']);
                        $rm->setIsDeleted('1');
                        $rm->save();
                    }
                }

                //delete report associate
                if($reports) {
                    foreach ($reports as $report) {
                        $r = new Report();
                        $r->setId($report['id']);
                        $r->setIsDeleted('1');
                        $r->save();
                    }
                }

                //delete group
            $review->setIsDeleted(1);
            $review->save();
            Cache::clear('app_admin_report');
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_report'));
        } else {
            Message::create('Warning', 'Identifiant introuvable');
            $this->redirect(Framework::getUrl('app_admin_review'));
        }
    }

}