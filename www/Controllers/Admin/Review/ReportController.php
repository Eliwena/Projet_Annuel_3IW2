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

class ReportController extends AbstractController
{

    public function indexAction(){
        $reports = ReportRepository::getReport();
        $this->render("admin/report/list", ['reports' => $reports], 'back');
    }

    public function showAction() {
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
        if(isset($_GET['id'])) {
            $review = ReviewRepository::getReviewById($_GET['id']);

                //init data
                $reviewMenus = ReviewMenuRepository::getReviewMenus($review);
                $reports = ReportRepository::getReportByReviewId($review);

                //delete all reviewmenu associate
                if($reviewMenus) {
                    foreach ($reviewMenus as $reviewMenu) {
                        $rm = new ReviewMenu();
                        $rm->setId($reviewMenu['id']);
                        $rm->setIsDeleted(1);
                        $rm->save();
                    }
                }

                //delete report associate
                if($reports) {
                    foreach ($reports as $report) {
                        $r = new Report();
                        $r->setId($report['id']);
                        $r->setIsDeleted(1);
                        $r->save();
                    }
                }

                //delete group
            $review->setIsDeleted(1);
            $review->save();
            Cache::clear('app_admin_report');
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_review'));
        }
        Message::create('Warning', 'Identifiant introuvable');
        $this->redirect(Framework::getUrl('app_admin_review'));
    }

}